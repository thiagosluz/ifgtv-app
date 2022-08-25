<?php

namespace App\Http\Controllers;

use App\Jobs\ImagemOtimizarJob;
use App\Jobs\SendEmailJob;
use App\Mail\PostsStatus;
use App\Models\Publication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function index()
    {
//        $publications = Publication::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $publications = Publication::sortable(['id' => 'desc'])->with('user')->paginate(10);
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
        $request->validate([
            'tipo' => 'required',
        ]);

        if ($request->tipo == 'imagem') {
            $request->validate([
                'titulo' => 'required|max:255',
                'imagem' => 'required|image|mimes:jpeg,png,jpg,svg',
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
                    $canvas->save(public_path('publish/tv/'. $fileName .'.png'));
//                  chamar job para otimizar imagem
                    dispatch(new ImagemOtimizarJob($fileName));

                }
            }elseif ($request->tipo == 'video') {
                $file = $request->video;
                $fileName = "publi_tv_".time();
                $file->move(public_path('publish/tv/'), $fileName .'.mp4');

            }



            $publication = new Publication();
            $publication->titulo = $request->titulo;
            $publication->texto = $request->texto;
            if ($request->tipo == 'imagem') {
                $publication->imagem = $fileName .'.png';
                $publication->tipo = 'imagem';
            }elseif ($request->tipo == 'video') {
                $publication->imagem = $fileName .'.mp4';
                $publication->tipo = 'video';
            }elseif ($request->tipo == 'texto') {
                $publication->tipo = 'texto';
                $publication->imagem = $request->cores;
            }
            $publication->user_id = auth()->user()->id;
            $publication->data_expiracao = $request->data_expiracao;
            $publication->save();

            //enviar email para todos os usuários com permissão de publicar
            $role = Role::with('users')->where('name', 'moderador')->first();
            foreach ($role->users as $user) {
                dispatch(new SendEmailJob($publication, 'Nova Publicação', $user->email));
            }

            return redirect()->route('publications.index')->with('success', 'Publicação criada com sucesso!');

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
    public function edit(Publication $publication)
    {
        $user = auth()->user();
        if ( ($user->id == $publication->user_id) || (auth()->user()->can('publications-moderador')) ) {
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
    public function update(Request $request, Publication $publication)
    {
        //pegar id do usuario logado
        $user = auth()->user();
        if ( ($user->id == $publication->user_id) || (auth()->user()->can('publications-moderador')) ) {

            if ($publication->tipo == 'imagem') {
                $request->validate([
                    'titulo' => 'required|max:255',
                    'imagem' => 'required|image|mimes:jpeg,png,jpg,svg',
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
                        $canvas->save(public_path('publish/tv/'. $fileName .'.png'));
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
                    $publication->imagem = $fileName .'.png';
                    $publication->tipo = 'imagem';
                }elseif ($publication->tipo == 'video') {
                    $publication->imagem = $fileName .'.mp4';
                    $publication->tipo = 'video';
                }elseif ($publication->tipo == 'texto') {
                    $publication->tipo = 'texto';
                    $publication->imagem = $request->cores;
                }

                $publication->data_expiracao = $request->data_expiracao;

                $publication->update();

                return redirect()->route('publications.index')->with('success', 'Publicação atualizada com sucesso!');


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
    public function destroy(Publication $publication)
    {

        $user = auth()->user();

        if ( ($user->id == $publication->user_id) || (auth()->user()->can('publications-moderador')) ) {

            try {
                $publication->delete();
                return redirect()->route('publications.index')->with('success', 'Publicação excluída com sucesso!');
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
        try {
            $publication = Publication::find($id);
            $publication->publicado = true;
            $publication->status = 3;
            $publication->update();
            return redirect()->route('publications.index')->with('success', 'Publicação aparecendo nas TVs!');
        }catch (\Exception $e) {
            Log::error('Não foi possível publicar a publicação: ' . $e->getMessage());
            return redirect()->route('publications.index')->with('error', 'Não foi possível publicar!');
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

        for ($i = 0; $i < count($lines); $i++) {
            $offset = 820 + ($i * 50); // 50 is line height
            $img->text($lines[$i], 110, $offset, function ($font) {
                $font->file(public_path('fonts/Roboto-Black.ttf'));
                $font->size(30);
                $font->color('#000000');
            });
        }

        $img->save(public_path('publish/tv/hardik3.png'));

        dd('ok');

    }


}
