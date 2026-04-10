@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: var(--nav-bg)">Agendamentos</h3>
        <a href="{{ route('agendamentos.create') }}" class="btn btn-novo shadow-sm">
            <i class="fas fa-calendar-plus me-2"></i> Novo Agendamento
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="card custom-card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 py-3">Cliente</th>
                        <th>Profissional</th>
                        <th>Serviço</th>
                        <th class="text-center">Data/Hora</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendamentos as $agendamento)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $agendamento->cliente->nome ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $agendamento->profissional->nome ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $agendamento->servico->nome ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = match($agendamento->status) {
                                        'pendente' => 'bg-warning text-dark',
                                        'concluído' => 'bg-success text-white',
                                        'cancelado' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($agendamento->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-sm btn-edit-custom me-1">Editar</a>
                                <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Excluir agendamento?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">Nenhum agendamento encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            <a href="/exportar-agendamentos" class="btn btn-success">📊 Exportar Relatório</a>
        </div>
    </div>
</div>
@endsection