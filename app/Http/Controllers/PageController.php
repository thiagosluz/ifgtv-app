<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
//    construtor
    public function __construct()
    {
        $this->middleware('auth');
        // set permission
        $this->middleware('permission:pages-list|pages-create|pages-edit|pages-delete', ['only' => ['index','show']]);
        $this->middleware('permission:pages-create', ['only' => ['create','store']]);
        $this->middleware('permission:pages-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pages-delete', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $pages = Page::orderBy('order')->paginate(30);

        return view('sistema.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sistema.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required|numeric',
            'text' => 'required|string',
            'url' => 'required|string',
            'icon' => 'required|string',
            'can' => 'string',
        ]);

        // Crie uma nova instância de Page com os dados do formulário
        $page = new Page();
        $page->order = $request->order;
        $page->text = $request->text;
        $page->url = $request->url;
        $page->icon = $request->icon;
        $page->can = $request->can;

        // Salve a nova página no banco de dados
        $page->save();

        // Redirecione de volta para a página de listagem de páginas com uma mensagem de sucesso
        return redirect()->route('pages.index')->with('success', 'Página criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }

    //ordenar
    public function order(Request $request)
    {

        $total_items = count($request->order);

            $data = $request->all();
            $orden = $data['order'];
            foreach ($orden as  $key => $v) {
                $page = Page::find($v);
                $page->order = $key+1;
                $page->update();
            }
            return response()->json(['Menu Ordenado, atualize a página.'], 200);

    }
}
