<?php

namespace App\Http\Controllers;

use App\Exports\BirthdaysExport;
use App\Imports\BirthdayImport;
use App\Jobs\BirthdayImportJob;
use App\Models\Birthday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class BirthdayController extends Controller
{
    //construtor com permissão de acesso
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:birthdays-list|birthdays-create|birthdays-edit|birthdays-delete', ['only' => ['index','show']]);
        $this->middleware('permission:birthdays-create')->only(['create', 'store']);
        $this->middleware('permission:birthdays-edit')->only(['edit', 'update']);
        $this->middleware('permission:birthdays-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

       // dd($request->all());
        $query = Birthday::query();


        // Filtrando por nome se fornecido
        if ($request->has('search_name') && $request->input('search_name') != '') {
            $query->where('name', 'like', '%' . $request->input('search_name') . '%');
        }

        // Filtrando por intervalo de datas se fornecido
        if ($request->has('start_date') && is_null($request->input('start_date')) == false) {
            $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'));

            $query->whereMonth('birthday', $startDate->month)
                ->whereDay('birthday', '>=',$startDate->day);
        }

        if ($request->has('end_date') && is_null($request->input('end_date')) == false) {

            $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
            $query->whereMonth('birthday', $endDate->month)
                ->whereDay('birthday', '<=',$endDate->day);
        }

       // dd($query->toSql());

        $birthdays = $query->sortable()->paginate(10);

        return view('sistema.birthdays.index', compact('birthdays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sistema.birthdays.create');
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
            'name' => 'required|max:255',
            'birthday' => 'required',
        ]);

        try {
            $birthday = new Birthday();
            $birthday->name = $request->name;
            $birthday->birthday = Carbon::createFromFormat('d/m/Y', $request->birthday);
            $birthday->save();
            return redirect()->route('birthdays.index')->with('success', 'Aniversariante cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('birthdays.index')->with('error', 'Erro ao cadastrar aniversariante!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\Response
     */
    public function show(Birthday $birthday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Birthday $birthday)
    {
        return view('sistema.birthdays.edit', compact('birthday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Birthday $birthday)
    {
        $request->validate([
            'name' => 'required|max:255',
            'birthday' => 'required',
        ]);

        try {
            $birthday->name = $request->name;
            $birthday->birthday = Carbon::createFromFormat('d/m/Y', $request->birthday);
            $birthday->update();
            return redirect()->route('birthdays.index')->with('success', 'Aniversariante atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('birthdays.index')->with('error', 'Erro ao atualizar aniversariante!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Birthday  $birthday
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Birthday $birthday)
    {
        try {
            $birthday->delete();
            return redirect()->route('birthdays.index')->with('success', 'Aniversariante excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('birthdays.index')->with('error', 'Erro ao excluir aniversariante!');
        }

    }

    public function fileImport(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        //Excel::import(new BirthdayImport, $request->file('file')->store('temp'));
        dispatch(new BirthdayImportJob( $request ));
        return redirect()->route('birthdays.index')->with('success', 'Estamos fazendo a importação, em breve os aniversáriantes estarão importados!');
    }


    public function modelo()
    {
        return response()->download(public_path('csv/aniversarios.csv'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $birthdays = Birthday::where('name', 'LIKE', "%{$search}%")->get();

        return response()->json($birthdays);
    }

    public function export(Request $request)
    {
        $query = Birthday::query();

        // Filtrando por nome se fornecido
        if ($request->has('search_name') && $request->input('search_name') != '') {
            $query->where('name', 'like', '%' . $request->input('search_name') . '%');
        }

        // Filtrando por intervalo de datas se fornecido
        if ($request->has('start_date') && is_null($request->input('start_date')) == false) {
            $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'));

            $query->whereMonth('birthday', $startDate->month)
                ->whereDay('birthday', '>=',$startDate->day);
        }

        if ($request->has('end_date') && is_null($request->input('end_date')) == false) {

            $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'));
            $query->whereMonth('birthday', $endDate->month)
                ->whereDay('birthday', '<=',$endDate->day);
        }


        $birthdays = $query->get();

        return Excel::download(new BirthdaysExport($birthdays), 'aniversariantes.xlsx');
    }

}
