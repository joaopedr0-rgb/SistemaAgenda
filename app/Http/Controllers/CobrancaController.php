<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CobrancaController extends Controller
{
    /* SINTAXE: Método index() do CobrancaController.
    SEMÂNTICA: Responsável por listar o resumo financeiro. Ele agrupa os agendamentos "concluídos" para mostrar o total bruto e as comissões.
    */
    public function index()
    {
        // Buscamos apenas os agendamentos que já foram finalizados (status 'concluido')
        $agendamentos = \App\Models\Agendamento::where('status', 'concluido')->with(['servico', 'profissional'])->get();

        // Cálculos Rápidos:
        $faturamentoTotal = $agendamentos->sum(function($a) {
            return $a->servico->preco ?? 0;
        });

        $totalComissoes = $agendamentos->sum('valor_comissao_pago');

        $lucroSalao = $faturamentoTotal - $totalComissoes;

        return view('cobrancas.index', compact('agendamentos', 'faturamentoTotal', 'totalComissoes', 'lucroSalao'));
    }
}
