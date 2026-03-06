<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;

class AgendamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentos = Agendamento::all();
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.index', compact('agendamentos', 'clientes', 'profissionais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.create', compact('clientes', 'profissionais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:funcionarios,id',
            'servico_id' => 'required|exists:servicos,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);
        Agendamento::create($validated);
        return redirect()->route('agendamentos.index');
    }

    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agendamento $agendamento)
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        return view('agendamentos.edit', compact('agendamento', 'clientes', 'profissionais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request -> validate([
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:funcionarios,id',
            'servico_id' => 'required|exists:servicos,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);
        $agendamento->update($validated);
        return redirect()->route('agendamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        return redirect()->route('agendamentos.index');
    }
}
