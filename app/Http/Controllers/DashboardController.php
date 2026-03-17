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
}
