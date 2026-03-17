@extends('layouts.app')

@section('content')
<style>
    /* Fundo da Dashboard acompanhando o tema */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh;
    }

    /* Título da Página */
    .page-title {
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    /* Cards de Estatísticas */
    .stat-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        color: #333;
    }

    .stat-label {
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    /* Botões de Ação Rápida */
    .btn-quick-action {
        border-radius: 15px;
        padding: 15px;
        font-weight: 700;
        text-transform: uppercase;
        transition: all 0.3s;
        border: 2px solid white;
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .btn-quick-action:hover {
        background: white;
        color: #3A0256;
    }
</style>

<div class="container pb-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="page-title">Bem-vindo ao Dashboard</h1>
            <p class="text-white opacity-75 mb-5">Visão geral do seu sistema de agendamentos</p>
        </div>
    </div>

    {{-- Cards de Resumo --}}
    <div class="row text-center">
        {{-- Exemplo de Card Funcional --}}
        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <i class="fas fa-user-md stat-icon"></i>
                <div class="stat-value">{{ $profissionaisCount ?? '0' }}</div>
                <div class="stat-label">Profissionais</div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-value">{{ $clientesCount ?? '0' }}</div>
                <div class="stat-label">Clientes</div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <i class="fas fa-concierge-bell stat-icon"></i>
                <div class="stat-value">{{ $servicosCount ?? '0' }}</div>
                <div class="stat-label">Serviços</div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card stat-card p-4">
                <i class="fas fa-calendar-check stat-icon"></i>
                <div class="stat-value">{{ $agendamentosCount ?? '0' }}</div>
                <div class="stat-label">Agendamentos</div>
            </div>
        </div>
    </div>

    {{-- Ações Rápidas --}}
   
@endsection