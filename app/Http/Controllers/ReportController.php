<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //controller para deixar apenas usuarios logados acessar
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sistema.relatorios.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required'
        ]);

        $publications = [];
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_type = $request->report_type;
        $user = Auth::user();

        // Se o usuário tiver a permissão de moderador ou for um super-admin
        if ($user->hasRole('Super-Admin')) {
            $publications = Publication::whereBetween('created_at', [$start_date, $end_date])
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
                ->groupBy('year', 'month')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->get()
                ->map(function ($publication) {
                    $publication->month_year = str_pad($publication->month, 2, '0', STR_PAD_LEFT) . '/' . $publication->year;
                    return $publication;
                });
        } else {

            if ($report_type == 'individual') {
                // Se o usuário não for moderador ou super-admin, filtrar as publicações pelo usuário
                $publications = Publication::where('user_id', $user->id)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    //->whereBetween('created_at', [$start_date, $end_date])
                    ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
                    ->groupBy('year', 'month')
                    ->orderByDesc('year')
                    ->orderByDesc('month')
                    ->get()
                ->map(function ($publication) {
                    $publication->month_year = str_pad($publication->month, 2, '0', STR_PAD_LEFT) . '/' . $publication->year;
                    return $publication;
                });
            }elseif ($report_type == 'setor'){
                // Se o usuário não for moderador ou super-admin, filtrar as publicações pelo setor do usuário
                $publications = Publication::where('setor_id', $user->setor_id)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                   // ->whereBetween('created_at', [$start_date, $end_date])
                    ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
                    ->groupBy('year', 'month')
                    ->orderByDesc('year')
                    ->orderByDesc('month')
                    ->get()
                ->map(function ($publication) {
                    $publication->month_year = str_pad($publication->month, 2, '0', STR_PAD_LEFT) . '/' . $publication->year;
                    return $publication;
                });
            }

        }

    //    dd($publications);

        return view('sistema.relatorios.report_result', compact('publications', 'start_date', 'end_date', 'report_type'));
    }


}
