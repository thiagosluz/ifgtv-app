<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        //teste de criação de regras
//        for($i=0;$i<10;$i++){
//            $role3 = Role::create(['name' => 'teste_'.$i]);
//        }

        $roles = Role::paginate(10);
        return view('sistema.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('sistema.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:roles,name|max:255',
                'permissions' => 'required',
            ],
            [
                'name.required' => 'O nome da regra é obrigatório',
                'name.unique' => 'O nome da regra já existe',
                'name.max' => 'O nome da regra deve ter no máximo 255 caracteres',
                'permissions.required' => 'Selecione pelo menos uma permissão',
            ]);

        try {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);
            return redirect()->route('roles.index')->with('success', 'Regra criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar regra: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Regra não criada!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('sistema.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request,
            [
                'name' => 'required|max:255|unique:roles,name,'.$role->id,
                'permissions' => 'required',
            ],
            [
                'name.required' => 'O nome da regra é obrigatório',
                'name.max' => 'O nome da regra deve ter no máximo 255 caracteres',
                'name.unique' => 'O nome da regra já existe',
                'permissions.required' => 'Selecione pelo menos uma permissão',
            ]);

        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);
            return redirect()->route('roles.index')->with('success', 'Regra atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar regra: ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Regra não atualizada!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        try{
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Regra deletada com sucesso!');
        }catch(\Exception $e){
            Log::error('Erro ao deletar regra : ' . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Erro ao deletar a regra!');
        }

    }
}
