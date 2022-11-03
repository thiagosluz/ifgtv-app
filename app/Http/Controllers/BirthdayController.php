<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function index()
    {
        $birthdays = Birthday::sortable(['name' => 'asc'])->paginate(10);
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
}
