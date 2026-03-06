<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Profissional;
use Illuminate\Http\Request;

class AgendamentosController extends Controller
{



    public function index()
    {
        $agendamentos = Agendamento::all();
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        return view('agendamento.index', compact('agendamentos', 'clientes', 'profissionais'));
    }




    public function create()
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        return view('agendamento.create', compact('clientes', 'profissionais'));
    }




    public function store(Request $request)
    {
        $validated = $request -> validate([
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:funcionarios,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);
        Agendamento::create($validated);
        return redirect()->route('agendamentos.index');
    }




   




    public function edit(Agendamento $agendamento)
    {
        $clientes = Cliente::all();
        $profissionais = Profissional::all();

        return view('agendamento.edit', compact('agendamento', 'clientes', 'profissionais'));
    }




    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request -> validate([
            'cliente_id' => 'required|exists:clientes,id',
            'profissional_id' => 'required|exists:funcionarios,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);
        $agendamento->update($validated);
        return redirect()->route('agendamentos.index');
    }



    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        return redirect()->route('agendamentos.index');
    }
}
