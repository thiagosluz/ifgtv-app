<?php

namespace App\Http\Controllers;


use App\Models\Publication;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $labels = ['Sem publicações'];
        $data = ['0'];

        $publi = Publication::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('month_name, MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) ASC')
            ->pluck('count', 'month_name');

        if ($publi->count() > 0) {
            $labels = $publi->keys();
            $data = $publi->values();
        }

        $publicados = Publication::publicado()->exibir()->count();
        $aguardando = Publication::where('publicado', 0)->count();
        $users_without_any_roles = User::doesntHave('roles')->count();

        return view('home', compact('publicados', 'aguardando', 'users_without_any_roles', 'labels', 'data'));
    }
}
