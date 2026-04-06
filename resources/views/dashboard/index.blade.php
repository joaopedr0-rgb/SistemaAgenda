@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <div class="row mb-5 text-center">
        <div class="col-12">
            <h1 class="fw-bold" style="color: var(--nav-bg)">Painel de Gestão</h1>
            <p class="text-muted">Dados reais extraídos do banco de dados</p>
        </div>
    </div>

    {{-- Cards de Resumo (Estes você já tinha, mantive iguais) --}}
    <div class="row mb-5">
        <div class="col-md-3 mb-4">
            <div class="card p-4 shadow-sm border-0 text-center" style="border-radius: 20px;">
                <i class="fas fa-users fa-2x mb-2" style="color: var(--nav-bg)"></i>
                <h3 class="fw-bold mb-0">{{ $clientesCount ?? '0' }}</h3>
                <small class="text-muted fw-bold">CLIENTES</small>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 shadow-sm border-0 text-center" style="border-radius: 20px;">
                <i class="fas fa-calendar-check fa-2x mb-2" style="color: var(--nav-bg)"></i>
                <h3 class="fw-bold mb-0">{{ $agendamentosCount ?? '0' }}</h3>
                <small class="text-muted fw-bold">AGENDAMENTOS</small>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 shadow-sm border-0 text-center" style="border-radius: 20px;">
                <i class="fas fa-cut fa-2x mb-2" style="color: var(--nav-bg)"></i>
                <h3 class="fw-bold mb-0">{{ $servicosCount ?? '0' }}</h3>
                <small class="text-muted fw-bold">SERVIÇOS</small>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4 shadow-sm border-0 text-center" style="border-radius: 20px;">
                <i class="fas fa-user-tie fa-2x mb-2" style="color: var(--nav-bg)"></i>
                <h3 class="fw-bold mb-0">{{ $profissionaisCount ?? '0' }}</h3>
                <small class="text-muted fw-bold">EQUIPE</small>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 25px;">
                <div class="card-header bg-transparent fw-bold text-center border-0 pt-4">Procura por Serviço</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartServicos"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 25px;">
                <div class="card-header bg-transparent fw-bold text-center border-0 pt-4">Status dos Agendamentos</div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart1, chart2;

        // --- CAPTURA DE DADOS REAIS DO SISTEMA ---
        // Aqui pegamos o que o Controller enviou e jogamos no JS
        const labelsServicos = @json($servicosLabels ?? []);
        const dadosServicos = @json($servicosValues ?? []);

        const labelsStatus = @json($statusLabels ?? ['Pendente', 'Concluido', 'Cancelado']);
        const dadosStatus = @json($statusValues ?? [0, 0, 0]);

        function renderCharts() {
            const isSummer = document.documentElement.getAttribute('data-theme') === 'summer';

            const colors = isSummer
                ? ['#722F37', '#A64452', '#E7C1B1', '#C19A6B']
                : ['#1B3A57', '#0D47A1', '#64FFDA', '#112240'];

            const labelColor = isSummer ? '#333' : '#E6F1FF';

            if (chart1) chart1.destroy();
            if (chart2) chart2.destroy();

            // Gráfico 1: Serviços Reais
            chart1 = new Chart(document.getElementById('chartServicos'), {
                type: 'pie',
                data: {
                    labels: labelsServicos.length ? labelsServicos : ['Sem dados'],
                    datasets: [{
                        data: dadosServicos.length ? dadosServicos : [1],
                        backgroundColor: colors,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: labelColor } } }
                }
            });

            // Gráfico 2: Status Reais
            chart2 = new Chart(document.getElementById('chartStatus'), {
                type: 'doughnut',
                data: {
                    labels: labelsStatus,
                    datasets: [{
                        data: dadosStatus,
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: labelColor } } }
                }
            });
        }

        // Inicialização e Observador de Tema (Responsividade de Cor)
        document.addEventListener('DOMContentLoaded', renderCharts);
        const observer = new MutationObserver(() => renderCharts());
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    </script>
    <div id="calendario"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cal = new FullCalendar.Calendar(document.getElementById('calendario'), {
                locale: 'pt-br',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },

                // aqui o Laravel injeta os agendamentos via rota
                events: '{{ route("agendamentos.json") }}',

                eventClick: function (info) {
                    alert('Agendamento: ' + info.event);
                }
            });

            cal.render();
        });
    </script>
@endsection