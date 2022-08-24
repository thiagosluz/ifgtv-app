<?php

namespace App\Http\Controllers;


use App\Models\Publication;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $publicados = Publication::publicado()->exibir()->count();
        $aguardando = Publication::where('publicado', 0)->count();

        return view('home',compact('publicados','aguardando'));
    }
}
