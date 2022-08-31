<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //controla o acesso a esta página
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:config-list');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $config = Config::first();
        return view('sistema.config.index', compact('config'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tempo' => 'required',
            'frase' => 'required',
        ]);

        try {
            $config = Config::findOrFail($id);
            $config->slide_time = $request->tempo;
            $config->birthday_message = $request->frase;
            $config->update();
            return redirect()->route('config.index')->with('success', 'Configurações atualizadas com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('config.index')->with('error', 'Erro ao atualizar configurações!');
        }

    }

}
