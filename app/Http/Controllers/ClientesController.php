<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    
    public function index()
    {
        $cliente = Cliente::all();
        return view("clientes.index", compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'nome' => 'required',
            'email' => 'required|email|unique:_clientes,email',
            'telefone' => 'nullable',
            'status' => 'nullable',
        ]);

        Cliente::create($validated);
        return redirect()->route('clientes.index');
    }

 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());
        $cliente->update($request->all()); 
        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente = Cliente::findOrFail($cliente->id);
        $cliente->delete();
        return redirect()->route('clientes.index');
    }
}
