<?php

namespace App\Http\Controllers;


use App\Models\Publication;
use App\Models\User;

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
        $users_without_any_roles = User::doesntHave('roles')->count();

        return view('home',compact('publicados','aguardando', 'users_without_any_roles'));
    }
}
