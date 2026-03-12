<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;

class AgendamentosController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::all();
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.index', compact('agendamentos', 'clientes', 'profissionais'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();
        $servicos = Servico::all();

        return view('agendamentos.create', compact('clientes', 'profissionais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id', 
            'servico_id'      => 'required|exists:servicos,id',
            'data'            => 'required|date',
            'hora'            => 'required|date_format:H:i',
        ]);
        
        Agendamento::create($validated);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado!');
    }

    public function edit(Agendamento $agendamento)
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        return view('agendamentos.edit', compact('agendamento', 'clientes', 'profissionais'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:profissionais,id',
            'servico_id'      => 'required|exists:servicos,id',
            'data'            => 'required|date',
            'hora'            => 'required|date_format:H:i',
        ]);

        $agendamento->update($validated);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado!');
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido!');
    }
}