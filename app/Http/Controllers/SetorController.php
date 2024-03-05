<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SetorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:setores-list|setores-create|setores-edit|setores-delete', ['only' => ['index','show']]);
        $this->middleware('permission:setores-create')->only(['create', 'store']);
        $this->middleware('permission:setores-edit')->only(['edit', 'update']);
        $this->middleware('permission:setores-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $setores = Setor::orderBy('id', 'asc')->paginate(10); // Altere conforme sua necessidade de ordenação e paginação
        return view('sistema.setores.index', compact('setores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sistema.setores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'nome' => 'required|max:255',
        ]);

        try {
            // Criar um novo setor com os dados do formulário
            $setor = new Setor();
            $setor->nome = $request->nome;
            $setor->save();

            return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
        } catch (\Exception $e) {
            // Lidar com erros e redirecionar de volta à página de criação
            return redirect()->route('setores.create')->with('error', 'Erro ao criar o setor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $setor = Setor::findOrFail($id);
        return view('sistema.setores.edit', compact('setor'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $setor = Setor::findOrFail($id);

            $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $setor->update($request->all());

            return redirect()->route('setores.index')
                ->with('success', 'Setor atualizado com sucesso!');
        } catch (ValidationException $e) {
            // Captura exceções de validação e redireciona de volta com erros
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Captura qualquer outra exceção não tratada
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o setor.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $setor = Setor::findOrFail($id);

            // Verificar se existem publicações associadas ao setor
            if ($setor->publications()->exists()) {
                return redirect()->route('setores.index')->with('error', 'Não é possível excluir o setor pois existem publicações associadas a ele.');
            }

            // Verificar se existem usuários associados ao setor
            if ($setor->users()->exists()) {
                return redirect()->route('setores.index')->with('error', 'Não é possível excluir o setor pois existem usuários associados a ele.');
            }

            // Se não houver publicações ou usuários associados, pode excluir o setor
            $setor->delete();

            return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
        } catch (\Exception $e) {
            // Lidar com erros e redirecionar de volta à página de listagem
            return redirect()->route('setores.index')->with('error', 'Erro ao excluir o setor: ' . $e->getMessage());
        }
    }
}
