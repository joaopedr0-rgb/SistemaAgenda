<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Agendamento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'profissionaisCount' => Profissional::count(),
            'clientesCount' => Cliente::count(),
            'servicosCount' => Servico::count(),
            'agendamentosCount' => Agendamento::count(),
        ]);
    }

    /**
     * Retorna os dados para os gráficos em formato JSON (API)
     */
    public function getStats()
    {
        // 1. Dados para a Pizza de Status (Realizados, Pendentes, Cancelados)
        // Certifique-se de que esses status existem na sua coluna 'status' da tabela agendamentos
        $statusLabels = ['Concluído', 'Pendente', 'Cancelado'];
        $statusValues = [
            Agendamento::where('status', 'concluido')->count(),
            Agendamento::where('status', 'pendente')->count(),
            Agendamento::where('status', 'cancelado')->count(),
        ];

        // 2. Dados para a Pizza de Serviços (Top 4 mais procurados)
        // Aqui buscamos os nomes dos serviços e a contagem de agendamentos para cada um
        $servicosData = Agendamento::selectRaw('servicos.nome, count(*) as total')
            ->join('servicos', 'agendamentos.servico_id', '=', 'servicos.id')
            ->groupBy('servicos.nome')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        return response()->json([
            'statusLabels' => $statusLabels,
            'statusValues' => $statusValues,
            'servicosLabels' => $servicosData->pluck('nome'),
            'servicosValues' => $servicosData->pluck('total'),
        ]);
    }
}