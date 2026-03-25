@extends('layouts.app')

@section('content')
<div class="row mb-5 text-center">
    <div class="col-12">
        <h1 class="fw-bold" style="color: var(--nav-bg)">Painel de Gestão</h1>
        <p class="text-muted">Acompanhe seus agendamentos e serviços</p>
    </div>
</div>

{{-- Cards de Resumo --}}
<div class="row mb-5">
    <div class="col-md-3 mb-4">
        <div class="card p-3 shadow-sm border-0 text-center">
            <i class="fas fa-users fa-2x mb-2" style="color: var(--nav-bg)"></i>
            <h3 class="fw-bold mb-0">{{ $clientesCount ?? '0' }}</h3>
            <small class="text-muted fw-bold">CLIENTES</small>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card p-3 shadow-sm border-0 text-center">
            <i class="fas fa-calendar-check fa-2x mb-2" style="color: var(--nav-bg)"></i>
            <h3 class="fw-bold mb-0">{{ $agendamentosCount ?? '0' }}</h3>
            <small class="text-muted fw-bold">AGENDAMENTOS</small>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card p-3 shadow-sm border-0 text-center">
            <i class="fas fa-cut fa-2x mb-2" style="color: var(--nav-bg)"></i>
            <h3 class="fw-bold mb-0">{{ $servicosCount ?? '0' }}</h3>
            <small class="text-muted fw-bold">SERVIÇOS</small>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card p-3 shadow-sm border-0 text-center">
            <i class="fas fa-user-tie fa-2x mb-2" style="color: var(--nav-bg)"></i>
            <h3 class="fw-bold mb-0">{{ $profissionaisCount ?? '0' }}</h3>
            <small class="text-muted fw-bold">EQUIPE</small>
        </div>
    </div>
</div>

{{-- Gráficos de Pizza --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center">Procura por Serviço</div>
            <div class="card-body d-flex justify-content-center">
                <div style="width: 280px;"><canvas id="chartServicos"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center">Status dos Agendamentos</div>
            <div class="card-body d-flex justify-content-center">
                <div style="width: 280px;"><canvas id="chartStatus"></canvas></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart1, chart2;

    function renderCharts() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'summer';
        
        // Cores Rose vs Azul Marinho
        const colors = isDark 
            ? ['#1B3A57', '#0D47A1', '#64FFDA', '#112240'] 
            : ['#722F37', '#A64452', '#E7C1B1', '#C19A6B'];

        const labelColor = isDark ? '#E6F1FF' : '#333';

        if (chart1) chart1.destroy();
        if (chart2) chart2.destroy();

        chart1 = new Chart(document.getElementById('chartServicos'), {
            type: 'pie',
            data: {
                labels: ['Cabelo', 'Barba', 'Manicure', 'Pedicure'],
                datasets: [{ data: [35, 25, 25, 15], backgroundColor: colors, borderWidth: 0 }]
            },
            options: { plugins: { legend: { labels: { color: labelColor } } } }
        });

        chart2 = new Chart(document.getElementById('chartStatus'), {
            type: 'pie',
            data: {
                labels: ['Realizados', 'Pendentes', 'Cancelados'],
                datasets: [{ data: [60, 30, 10], backgroundColor: ['#28a745', '#ffc107', '#dc3545'], borderWidth: 0 }]
            },
            options: { plugins: { legend: { labels: { color: labelColor } } } }
        });
    }

    document.addEventListener('DOMContentLoaded', renderCharts);
    window.addEventListener('theme-changed', renderCharts);
    
    // Pequeno ajuste para garantir que o gráfico mude com o tema
    document.getElementById('theme-toggler').addEventListener('click', () => {
        setTimeout(renderCharts, 100);
    });
</script>
@endsection