@extends('layouts.app')


@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-800 mb-1">Gestão de Cobranças</h2>
            <p class="text-muted">Acompanhe e gerencie os pagamentos dos seus clientes.</p>
        </div>
        <a href="{{ route('agendamentos.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Nova Cobrança
        </a>
    </div>


    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Total Recebido</small>
                <h3 class="fw-800 text-success">R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Pendente</small>
                <h3 class="fw-800 text-warning">R$ {{ number_format($totalPendente, 2, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Em Atraso</small>
                <h3 class="fw-800 text-danger">R$ {{ number_format($totalAtrasado, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>


    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 25px !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 py-3 text-muted">CLIENTE</th>
                        <th class="border-0 py-3 text-muted">VALOR</th>
                        <th class="border-0 py-3 text-muted">VENCIMENTO</th>
                        <th class="border-0 py-3 text-muted text-center">STATUS</th>
                        <th class="pe-4 border-0 py-3 text-end text-muted">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendamentos as $a)
                    <tr>
                        <td class="ps-4 fw-600">{{ $a->cliente->nome ?? 'Cliente não identificado' }}</td>
                        <td class="fw-bold">R$ {{ number_format($a->servico->preco ?? 0, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->data)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($a->status == 'concluido')
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Pago</span>
                            @elseif($a->data < date('Y-m-d'))
                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">Atrasado</span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Pendente</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            @if($a->status == 'concluido')
                                <a href="{{ route('agendamentos.recibo', $a->id) }}" target="_blank" class="btn btn-light btn-sm rounded-circle" title="Imprimir Recibo">
                                    <i class="fas fa-print"></i>
                                </a>
                            @else
                                <button class="btn btn-primary btn-sm rounded-pill px-3">
                                    <i class="fas fa-paper-plane me-1"></i> Cobrar agora
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Nenhum registro de cobrança encontrado para o período.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
    /* Estilos específicos para a área de cobrança */
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .fw-800 { font-weight: 800; }
    .fw-600 { font-weight: 600; }

    .table th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr:last-child td {
        border-bottom: 0;
    }

    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }

    .card.overflow-hidden { border-radius: 25px !important; }
    /* Garante que a tabela não "escape" pelas bordas arredondadas */
</style>
@endsection
