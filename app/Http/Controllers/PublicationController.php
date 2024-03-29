<?php

namespace App\Http\Controllers;

use App\Jobs\ImagemOtimizarJob;
use App\Jobs\LogsPublicationJob;
use App\Jobs\SendEmailJob;
use App\Mail\PostsStatus;
use App\Models\Publication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use League\ColorExtractor\Palette;
use Spatie\Color\Rgb;
use ImageOptimizer;

class PublicationController extends Controller
{
    //construtor com permissão de acesso
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:publications-list|publications-create|publications-edit|publications-delete|publications-previa|permission:publications-publicar', ['only' => ['index','show']]);
        $this->middleware('permission:publications-create')->only(['create', 'store']);
        $this->middleware('permission:publications-edit')->only(['edit', 'update']);
        $this->middleware('permission:publications-delete')->only('destroy');
        //previa
        $this->middleware('permission:publications-previa')->only(['previa']);
        //publicar
        $this->middleware('permission:publications-publicar')->only(['post']);
        //teste
        $this->middleware('permission:publications-teste')->only(['imagemText']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

//        dd($request->all());
       // $publications = Publication::sortable(['id' => 'desc'])->with('user')->paginate(10);

        $query = Publication::query();

        if ($request->has('titulo') && !is_null($request->titulo)) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->has('status') && !is_null($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('tipo') && !is_null($request->tipo)) {
            $query->where('tipo', $request->tipo );
        }

        if ($request->has('autor') && !is_null($request->autor)) {
            $query->whereHas('user', function($userQuery) use ($request) {
                $userQuery->where('name', 'like', '%' . $request->autor . '%');
            });
        }

        $publications = $query->sortable(['id' => 'desc'])->with('user')->paginate(10);
        return view('sistema.publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sistema.publications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Verificar se a data de lançamento é maior que a data de expiração ou se a data de expiração esta null
        if(!is_null($request->data_expiracao)){
            if ($request->has('scheduled_at') && $request->scheduled_at > $request->data_expiracao) {
                return redirect()->back()->withInput()->withErrors(['scheduled_at' => 'A data de lançamento não pode posterior que a data de expiração.']);
            }
        }

        $request->validate([
            'tipo' => 'required',
        ]);

        if ($request->tipo == 'imagem') {
            $request->validate([
                'titulo' => 'required|max:255',
                'imagem' => 'required|image|mimes:jpeg,png,jpg,svg,webp',
            ]);
        }elseif ($request->tipo == 'video') {
            $request->validate([
                'titulo' => 'required|max:255',
                'video' => 'required|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
            ]);
        }elseif ($request->tipo == 'texto') {
            $request->validate([
                'titulo' => 'required|max:70',
                'texto' => 'required',
                'cores' => 'required',
            ]);
        }


        try {

            if ($request->tipo == 'imagem') {
                if($request->hasFile('imagem')) {

                    $fileName = "publi_tv_".time();
                    $file = $request->imagem;

                    //paleta de cores
                    $originalImage= $file;
                    $thumbnailImage = Image::make($originalImage);
                    $thumbnailImage->save(public_path('publish/thumbnail/'. $fileName .'.jpg'));
                    $palette = new \BrianMcdo\ImagePalette\ImagePalette( public_path('publish/thumbnail/' . $fileName . '.jpg') , 10, 1);
                    foreach ($palette as $color) {
                        $canvas = Image::canvas( config('ifgtv.imagem.largura') , config('ifgtv.imagem.altura'), $color->rgbString);
                    }

                    //redimensionar imagem
                    $image = Image::make($file->getRealPath())->resize(config('ifgtv.imagem.largura') , config('ifgtv.imagem.altura'), function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $canvas->insert($image, 'center');
                    $canvas->save(public_path('publish/tv/'. $fileName .'.webp'));
//                  chamar job para otimizar imagem
                    dispatch(new ImagemOtimizarJob($fileName));

                }
            }

            elseif ($request->tipo == 'video') {
                $file = $request->video;
                $fileName = "publi_tv_".time();
                $file->move(public_path('publish/tv/'), $fileName .'.mp4');

            }

            $publication = new Publication();
            $publication->titulo = $request->titulo;
            $publication->texto = $request->texto;
            if ($request->tipo == 'imagem') {
                $publication->imagem = $fileName .'.webp';
                $publication->tipo = 'imagem';
            }elseif ($request->tipo == 'video') {
                $publication->imagem = $fileName .'.mp4';
                $publication->tipo = 'video';
            }elseif ($request->tipo == 'texto') {
                $publication->tipo = 'texto';
                $publication->imagem = $request->cores;
            }
            $setor_id = auth()->user()->setor_id;
            $publication->user_id = auth()->user()->id;
            $publication->data_expiracao = $request->data_expiracao;
            $publication->setor_id = $setor_id;

            if ($request->has('scheduled_at')) {
                // Se uma data de agendamento foi fornecida, agende a postagem
                $publication->data_lancamento = $request->scheduled_at;
            } else {
                // Se não houver data de agendamento, defina a data de agendamento como a data atual
                $publication->data_lancamento = now();
            }

            $publication->save();

            //enviar email para todos os usuários com permissão de publicar
            $role = Role::with('users')->where('name', 'moderador')->first();

            foreach ($role->users as $user) {
                //if receber_notificacoes is true e o usuário ser do mesmo setor de quem criou a publicação
                if ($user->receber_notificacoes && ($user->setor_id == $setor_id)) {
                    dispatch(new SendEmailJob($publication, 'Nova Publicação', $user->email));
                }
            }

//            logs de criação de publicação
            dispatch(new LogsPublicationJob( $publication->id, auth()->user()->id, 'criou a publicação.' ));

            return redirect()->route('publications.show', $publication->id)->with('success', 'Publicação criada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Não foi possível criar a publicação: ' . $e->getMessage());
            return redirect()->route('publications.index')->with('error', 'Não foi possível criar a publicação');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Publication $publication)
    {
        return view('sistema.publications.show', compact('publication'));
    }


    public function previa($id)
    {
        $publication = Publication::find($id);

        return view('sistema.publications.previa', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $publication = Publication::findOrFail($id);

        if ($publication->publicado == 1){
            return redirect()->route('publications.index')->with('error', 'Não é possível editar uma publicação já publicada.');
        }

        //pegar id do usuario logado
        $user = auth()->user();

        // Verificar se o usuário logado é o autor da publicação
        if ($publication->user_id != $user->id) {
            // Verificar se o usuário logado pertence ao mesmo setor do autor da publicação
            if ($publication->user->setor_id != $user->setor_id) {
                if (!$user->hasRole('Super-Admin')){
                    // Se o usuário logado não for o autor da publicação, não pertencer ao mesmo setor, retornar erro
                    return redirect()->route('publications.index')->with('error', 'Você não tem permissão para editar esta publicação!');
                }
            }
        }

        if ( $user->can('publications-moderador') || $user->hasRole('Super-Admin') ) {
            return view('sistema.publications.edit', compact('publication'));
        }else{
            return redirect()->route('publications.index')->with('error', 'Você não tem permissão para editar esta publicação');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Verificar se a data de lançamento é maior que a data de expiração ou se a data de expiração esta null
        if(!is_null($request->data_expiracao)){
            if ($request->has('scheduled_at') && $request->scheduled_at > $request->data_expiracao) {
                return redirect()->back()->withInput()->withErrors(['scheduled_at' => 'A data de lançamento não pode posterior que a data de expiração.']);
            }
        }

        //pegar id do usuario logado
        $publication = Publication::findOrFail($id);
        $user = auth()->user();

        // Verificar se o usuário logado é o autor da publicação
        if ($publication->user_id != $user->id) {
            // Verificar se o usuário logado pertence ao mesmo setor do autor da publicação
            if ($publication->user->setor_id != $user->setor_id) {
                if (!$user->hasRole('Super-Admin')){
                    // Se o usuário logado não for o autor da publicação, não pertencer ao mesmo setor, retornar erro
                    return redirect()->route('publications.index')->with('error', 'Você não tem permissão para atualizar esta publicação!');
                }
            }
        }

        if ( $user->can('publications-moderador') ) {

            if ($publication->tipo == 'imagem') {
                $request->validate([
                    'titulo' => 'required|max:255',
                    'imagem' => 'required|image|mimes:jpeg,png,jpg,svg,webp',
                ]);
            }elseif ($publication->tipo == 'video') {
                $request->validate([
                    'titulo' => 'required|max:255',
                    'video' => 'required|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
                ]);
            }elseif ($publication->tipo == 'texto') {
                $request->validate([
                    'titulo' => 'required|max:255',
                    'texto' => 'required',
                    'cores' => 'required',
                ]);
            }

            try {

                if ($publication->tipo == 'imagem') {
                    if($request->hasFile('imagem')) {

                        $fileName = "publi_tv_".time();
                        $file = $request->imagem;

                        //paleta de cores
                        $originalImage= $file;
                        $thumbnailImage = Image::make($originalImage);
                        $thumbnailImage->save(public_path('publish/thumbnail/'. $fileName .'.jpg'));
                        $palette = new \BrianMcdo\ImagePalette\ImagePalette( public_path('publish/thumbnail/' . $fileName . '.jpg') , 10, 1);
                        foreach ($palette as $color) {
                            $canvas = Image::canvas( config('ifgtv.imagem.largura') , config('ifgtv.imagem.altura'), $color->rgbString);
                        }

                        //redimensionar imagem
                        $image = Image::make($file->getRealPath())->resize(config('ifgtv.imagem.largura') , config('ifgtv.imagem.altura'), function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $canvas->insert($image, 'center');
                        //salvar em webp
                        $canvas->save(public_path('publish/tv/'. $fileName .'.webp'));
                        //                  chamar job para otimizar imagem
                        dispatch(new ImagemOtimizarJob($fileName));

                    }

                }elseif ($publication->tipo == 'video') {
                    $file = $request->video;
                    $fileName = "publi_tv_".time();
                    $file->move(public_path('publish/tv/'), $fileName .'.mp4');

                }

                $publication->titulo = $request->titulo;
                $publication->texto = $request->texto;
                if ($publication->tipo == 'imagem') {
                    $publication->imagem = $fileName .'.webp';
                    $publication->tipo = 'imagem';
                }elseif ($publication->tipo == 'video') {
                    $publication->imagem = $fileName .'.mp4';
                    $publication->tipo = 'video';
                }elseif ($publication->tipo == 'texto') {
                    $publication->tipo = 'texto';
                    $publication->imagem = $request->cores;
                }

                $publication->data_expiracao = $request->data_expiracao;

                if ($request->has('scheduled_at')) {
                    // Se uma data de agendamento foi fornecida, agende a postagem
                    $publication->data_lancamento = $request->scheduled_at;
                } else {
                    // Se não houver data de agendamento, defina a data de agendamento como a data atual
                    $publication->data_lancamento = now();
                }

                $publication->update();

                dispatch(new LogsPublicationJob( $publication->id, $user->id, 'atualizou a publicação.' ));

                return redirect()->route('publications.show', $publication->id)->with('success', 'Publicação atualizada com sucesso!');


            }catch (\Exception $e) {
                Log::error('Não foi possível atualizar a publicação: ' . $e->getMessage());
                return redirect()->route('publications.index')->with('error', 'Não foi possível atualizar a publicação');
            }

        }else{

            return redirect()->route('publications.index')->with('error', 'Você não tem permissão para editar esta publicação');

        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $publication = Publication::findOrFail($id);
        $user = auth()->user();

        // Verificar se o usuário logado é o autor da publicação
        if ($publication->user_id != $user->id) {
            // Verificar se o usuário logado pertence ao mesmo setor do autor da publicação
            if ($publication->user->setor_id != $user->setor_id) {
                if (!$user->hasRole('Super-Admin')){
                    // Se o usuário logado não for o autor da publicação, não pertencer ao mesmo setor, retornar erro
                    return redirect()->route('publications.index')->with('error', 'Você não tem permissão para excluir esta publicação!');
                }
            }
        }

        if ( $user->can('publications-moderador') ) {

            try {
                $publication->delete();
                dispatch(new LogsPublicationJob( $publication->id, $user->id, 'Publicação foi apagada.' ));
                return redirect()->route('publications.index')->with('success', 'deletou a publicação.');
            } catch (\Exception $e) {
                Log::error('Não foi possível excluir a publicação: ' . $e->getMessage());
                return redirect()->route('publications.index')->with('error', 'Não foi possível excluir a publicação!');
            }

        }else{

            return redirect()->route('publications.index')->with('error', 'Você não tem permissão para excluir esta publicação');

        }

    }

    /**
     * Publicação de uma postagem
     * */

    public function post($id)
    {
        $publication = Publication::findOrFail($id);
        $user = auth()->user();

        // Verificar se o usuário logado é o autor da publicação
        if ($publication->user_id != $user->id) {
            // Verificar se o usuário logado pertence ao mesmo setor do autor da publicação
            if ($publication->user->setor_id != $user->setor_id) {
                if (!$user->hasRole('Super-Admin')){
                    // Se o usuário logado não for o autor da publicação, não pertencer ao mesmo setor, retornar erro
                    return redirect()->route('publications.index')->with('error', 'Você não tem permissão para publicar esta publicação!');
                }
            }
        }
        if ( $user->can('publications-moderador') ) {

            try {
                $publication->publicado = true;
                $publication->status = 3;
                $publication->update();
                dispatch(new LogsPublicationJob( $publication->id, $user->id, 'aprovou a publicação.' ));
                return redirect()->route('publications.index')->with('success', 'Publicação aparecendo nas TVs!');
            }catch (\Exception $e) {
                Log::error('Não foi possível publicar a publicação: ' . $e->getMessage());
                return redirect()->route('publications.index')->with('error', 'Não foi possível publicar!');
            }

        }else{
            return redirect()->route('publications.index')->with('error', 'Você não tem permissão para publicar esta publicação');
        }

    }

    public function despublicar($id)
    {
        $publication = Publication::findOrFail($id);
        $user = auth()->user();

        // Verificar se o usuário logado é o autor da publicação
        if ($publication->user_id != $user->id) {
            // Verificar se o usuário logado pertence ao mesmo setor do autor da publicação
            if ($publication->user->setor_id != $user->setor_id) {
                if (!$user->hasRole('Super-Admin')){
                    // Se o usuário logado não for o autor da publicação, não pertencer ao mesmo setor, retornar erro
                    return redirect()->route('publications.index')->with('error', 'Você não tem permissão para despublicar esta publicação!');
                }
            }
        }

        if ( $user->can('publications-moderador') ) {

            try {
                $publication->publicado = false;
                $publication->status = 1;
                $publication->update();
                dispatch(new LogsPublicationJob( $publication->id, $user->id, 'despublicou a postagem.' ));
                return redirect()->route('publications.show', $publication->id)->with('success', 'Postagem despublicada com sucesso!');
            }catch (\Exception $e) {
                Log::error('Não foi possível despublicar a postagem: ' . $e->getMessage());
                return redirect()->route('publications.index')->with('error', 'Não foi possível despublicar!');
            }

        }else{
            return redirect()->route('publications.index')->with('error', 'Você não tem permissão para despublicar esta publicação');
        }

    }

    public function imagemText(){

        $width       = 1200;
        $height      = 590;
        $center_x    = $width / 2;
        $center_y    = $height / 2;
        $max_len     = 36;
        $font_size   = 30;
        $font_height = 20;

        $text = 'The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog?';

        $lines = explode("\n", wordwrap($text, $max_len));
        $y = $center_y - ((count($lines) - 1) * $font_height);

        // configure with favored image driver (gd by default)
        Image::configure(['driver' => 'imagick']);

        $img = Image::make(public_path('publish/tv/modelo4.png'));

        // use callback to define details
        $img->text('This is a example', 200, 50, function($font) {
            $font->file(public_path('fonts/Roboto-Black.ttf'));
            $font->size(30);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
        });

        foreach ($lines as $line)
        {
            $img->text($line, $center_x, $y, function($font) use ($font_size){
                $font->file(public_path('fonts/Roboto-Black.ttf'));
                $font->size($font_size);
                $font->color('#000000');
                $font->align('center');
                $font->valign('center');
            });

            $y += $font_height * 2;
        }

        $description = '<b>and this is bold text</b>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.';

        $lines = explode("\n", wordwrap($description, 120)); // break line after 120 characters

//        for ($i = 0; $i < count($lines); $i++) {
//            $offset = 820 + ($i * 50); // 50 is line height
//            $img->text($lines[$i], 110, $offset, function ($font) {
//                $font->file(public_path('fonts/Roboto-Black.ttf'));
//                $font->size(30);
//                $font->color('#000000');
//            });
//        }

        $img->save(public_path('publish/tv/hardik3.png'));

        dd('ok');

    }



}
