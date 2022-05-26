<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use League\ColorExtractor\Palette;
use Spatie\Color\Rgb;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        $publications = Publication::publicado()->exibir()->get();
//        dd($publications);
        $publications = Publication::with('user')->orderBy('created_at', 'desc')->paginate(10);

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
                'titulo' => 'required|max:255',
                'texto' => 'required',
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
            }
            $publication->user_id = auth()->user()->id;
            $publication->data_expiracao = $request->data_expiracao;
            $publication->save();

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
        return view('sistema.publications.edit', compact('publication'));
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
            }

            $publication->data_expiracao = $request->data_expiracao;

            $publication->update();

            return redirect()->route('publications.index')->with('success', 'Publicação atualizada com sucesso!');


        }catch (\Exception $e) {
            Log::error('Não foi possível atualizar a publicação: ' . $e->getMessage());
            return redirect()->route('publications.index')->with('error', 'Não foi possível atualizar a publicação');
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

        try {
            $publication->delete();
            return redirect()->route('publications.index')->with('success', 'Publicação excluída com sucesso!');
        } catch (\Exception $e) {
            Log::error('Não foi possível excluir a publicação: ' . $e->getMessage());
            return redirect()->route('publications.index')->with('error', 'Não foi possível excluir a publicação!');
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


}
