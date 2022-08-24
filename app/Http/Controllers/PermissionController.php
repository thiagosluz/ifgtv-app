<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    //construtor com permissão de acesso
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:permissions-list|permissions-create|permissions-edit|permissions-delete', ['only' => ['index','show']]);
        $this->middleware('permission:permissions-create')->only(['create', 'store']);
        $this->middleware('permission:permissions-edit')->only(['edit', 'update']);
        $this->middleware('permission:permissions-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('sistema.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sistema.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions,name',
        ], [
            'name.required' => 'o campo nome é obrigatório',
            'name.max' => 'o campo nome deve ter no máximo 255 caracteres',
            'name.unique' => 'o nome informado já existe',
        ]);

        try{
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso!');
        }catch (\Exception $e){
            Log::error('erro ao criar permissão : ' .$e->getMessage());
            return redirect()->back()->with('error', 'Erro ao criar permissão!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Permission $permission)
    {
        return view('sistema.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:permissions,name,'.$permission->id,
        ], [
            'name.required' => 'o campo nome é obrigatório',
            'name.max' => 'o campo nome deve ter no máximo 255 caracteres',
            'name.unique' => 'o nome informado já existe',
        ]);

        try{
            $permission->update(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permissão atualizada com sucesso!');
        }catch (\Exception $e){
            Log::error('erro ao atualizar permissão : ' .$e->getMessage());
            return redirect()->back()->with('error', 'Erro ao atualizar permissão!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        try{
            $permission->delete();
            return redirect()->route('permissions.index')->with('success', 'Permissão deletada com sucesso!');
        }catch(\Exception $e){
            Log::error('Erro ao deletar permissão : ' . $e->getMessage());
            return redirect()->route('permissions.index')->with('error', 'Erro ao deletar a permissão!');
        }
    }
}
