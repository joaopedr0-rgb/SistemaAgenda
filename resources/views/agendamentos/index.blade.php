
@extends('layouts.app')

@section('content')
<style>
    /* Fundo padrão do sistema */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh;
    }

    /* Card da Tabela */
    .custom-card-table {
        border: none !important;
        border-radius: 20px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
        overflow: hidden;
    }

    /* Cabeçalho da Tabela */
    .table thead th {
        background-color: #f8f9fa !important;
        color: #3A0256 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.85rem;
        border-bottom: 2px solid #eee !important;
    }

    /* Estilo dos Badges de Status */
    .badge-ativo {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        padding: 6px 12px !important;
        border-radius: 50px !important;
        color: white !important;
    }

    .badge-inativo {
        background: #6c757d !important;
        padding: 6px 12px !important;
        border-radius: 50px !important;
        color: white !important;
    }

    /* Botões de Ação */
    .btn-edit-custom {
        color: #3A0256 !important;
        border: 1px solid #3A0256 !important;
        font-weight: 600 !important;
        transition: all 0.3s;
    }

    .btn-edit-custom:hover {
        background-color: #3A0256 !important;
        color: white !important;
    }

    .btn-delete-custom {
        color: #d81b60 !important;
        border: 1px solid #d81b60 !important;
        font-weight: 600 !important;
    }

    .btn-delete-custom:hover {
        background-color: #d81b60 !important;
        color: white !important;
    }

    /* Botão Novo Serviço */
    .btn-novo {
        background: white !important;
        color: #3A0256 !important;
        font-weight: 800 !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-white mb-0">Agendamentos</h3>
        <a href="{{ route('agendamentos.create') }}" class="btn btn-novo">
            <i class="bi bi-plus-lg"></i> Novo Agendamento
        </a>
    </div>

    <div class="card custom-card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="py-3">Profissional</th>
                            <th class="py-3 text-center">Data</th>
                            <th class="py-3 text-center">Hora</th>
                            <th class="py-3 text-center px-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendamentos as $agendamento)
                        <tr>
                            {{-- Nome do Cliente (Acessando relacionamento) --}}
                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $agendamento->cliente->nome ?? 'N/A' }}</span>
                            </td>

                            {{-- Nome do Profissional --}}
                            <td>
                                <span class="text-secondary">{{ $agendamento->profissional->nome ?? 'N/A' }}</span>
                            </td>

                            {{-- Data Formatada (Carbon) --}}
                            <td class="text-center">
                                <span class="date-badge">
                                    {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}
                                </span>
                            </td>

                            {{-- Hora Formatada (Carbon) --}}
                            <td class="text-center">
                                <span class="time-badge">
                                    {{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}
                                </span>
                            </td>

                            <td class="text-center px-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-sm btn-outline-warning fw-bold">
                                        Editar
                                    </a>

                                    <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x d-block mb-2 fs-2"></i>
                                Nenhum agendamento encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection