<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

//    construtor com permissão de acesso
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users-list|pages-create|pages-edit|pages-delete', ['only' => ['index','show']]);
        $this->middleware('permission:users-create')->only(['create', 'store']);
        $this->middleware('permission:users-edit')->only(['edit', 'update']);
        $this->middleware('permission:users-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        $publications = Publication::sortable(['id' => 'desc'])->with('user')->paginate(10);
        $users = User::sortable(['id' => 'desc'])->with('roles')->paginate(10);
        return view('sistema.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('sistema.users.create', compact('roles'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
        ], [
            'name.required' => 'o campo nome é obrigatório',
            'email.required' => 'o campo email é obrigatório',
            'password.required' => 'o campo senha é obrigatório',
            'password.confirmed' => 'as senhas não conferem',
            'role.required' => 'o campo role é obrigatório',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            //não permitir que a role Super-Admin seja atribuida a outro usuário
            if(in_array(1, $request->role)){
                return redirect()->route('users.index')->with('error', 'Não é permitido atribuir Super-Admin ao usuário!');
            }else{
                $user->roles()->sync($request->role);
            }
            return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
        }catch (\Exception $e) {
            Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Erro ao criar usuário!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('sistema.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('sistema.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {

        //se o usuario for Super-Admin não pode ser editado
        if ($user->hasRole('Super-Admin')) {
            return redirect()->route('users.index')->with('error', 'Usuário Super-Admin não pode ser editado!');
        }
        //função para atualizar user com request validate
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required',
        ], [
            'name.required' => 'o campo nome é obrigatório',
            'email.required' => 'o campo email é obrigatório',
            'password.required' => 'o campo senha é obrigatório',
            'password.confirmed' => 'as senhas não conferem',
            'role.required' => 'o campo role é obrigatório',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
            ]);
            //não permitir que a role Super-Admin seja atribuida a outro usuário

            if(in_array(1, $request->role)){
                return redirect()->route('users.index')->with('error', 'Não é permitido atribuir Super-Admin ao usuário!');
            }else{
                $user->roles()->sync($request->role);
            }

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
        }catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Erro ao atualizar usuário!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        //se o usuario for Super-Admin não pode ser deletado
        if ($user->hasRole('Super-Admin')) {
            return redirect()->route('users.index')->with('error', 'Usuário Super-Admin não pode ser deletado!');
        }
       try{
           $user->delete();
           return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
       }catch (\Exception $e) {
           Log::error('Erro ao excluir usuário: ' . $e->getMessage());
           return redirect()->route('users.index')->with('error', 'Erro ao excluir usuário!');
       }
    }


//    função de editar perfil
    public function editProfile()
    {
        $user = auth()->user();
        return view('sistema.users.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'o campo nome é obrigatório',
            'email.required' => 'o campo email é obrigatório',
            'password.confirmed' => 'as senhas não conferem',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
            ]);
            return redirect()->route('home')->with('success', 'Perfil atualizado com sucesso!');
        }catch (\Exception $e) {
            Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Erro ao atualizar perfil!');
        }
    }

}
