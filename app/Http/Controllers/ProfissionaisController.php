<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;

class ProfissionaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profissionais = Profissional::all();
        return view("profissionais.index", compact('profissionais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profissionais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'CPF' => 'required|unique:profissionais,CPF',
            'email' => 'required|email|unique:profissionais,email',
            'funcao' => 'required',
            'status' => 'nullable',
        ]);

        Profissional::create($validated);
        return redirect()->route('profissionais.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profissional $profissional)
    {
        return view('profissionais.edit', compact('profissional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profissional $profissional)
    {
        $profissional->update($request->all());
        $profissional->update($request->all());
        return redirect()->route('profissionais.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // O nome da variável $profissional deve ser exatamente esse se você usa Route::resource
// No seu ProfissionalController.php
    public function destroy($id) // Recebe apenas o ID
    {
        $profissional = Profissional::find($id);

        if ($profissional) {
            $profissional->delete();
            return redirect()->route('profissionais.index')->with('success', 'Excluído!');
        }

        return redirect()->route('profissionais.index')->with('error', 'Não encontrado.');
    }
}
