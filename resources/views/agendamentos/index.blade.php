@extends('layouts.app')

@section('content')
    <style>
        @keyframes gradientAnimation {
            0% {
                background-position: 20% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 20% 50%;
            }
        }

        .container h2,
        .container h3,
        .page-title,
        .text-white-custom {
            color: #ffffff !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3) !important;
            transition: none !important;
            /* Mantém branco independente do tema */
        }

        body {
            background: var(--bg-gradient) !important;
            background-size: 400% 400% !important;
            animation: gradientAnimation 15s ease infinite !important;
            background-attachment: fixed !important;
            min-height: 100vh;
            transition: background 0.5s ease;
        }

        .custom-card-form {
            color: var(--text-primary) !important;
            border: none !important;
            border-radius: 20px !important;
            backdrop-filter: blur(5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3) !important;
            transition: color 0.5s ease;
        }

        .custom-card-table{
            color: var(--text-primary) !important;
            border: none !important;
            border-radius: 20px !important;
            overflow: hidden;
            backdrop-filter: blur(5px);
            transition: color 0.5s ease;
        }

        .table thead th {
            background-color: #f8f9fa !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eee !important;
        }

        /* Linhas da Tabela */
        .table tbody td {
            vertical-align: middle !important;
            color: var(--text-primary) !important;
        }

        /* Badges de Status Personalizados */
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
        }

        /* Botão Editar: Branco com contorno roxo */
        .btn-edit-custom {
            color: var(--text-primary) !important;
            border: 1px solid var(--text-primary) !important;
            font-weight: 600 !important;
            transition: all 0.3s;
        }

        .btn-edit-custom:hover {
            background-color: var(--text-primary) !important;
            color: white !important;
        }

        .btn-delete-custom {
            color: #d81b60 !important;
            border: 1px solid #d81b60 !important;
            font-weight: 600 !important;
            transition: all 0.3s;
        }

        .btn-delete-custom:hover {
            background-color: #d81b60 !important;
            color: white !important;
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold mb-0">Agendamentos</h2>
            <a href="{{ route('agendamentos.create') }}" class="btn btn-light px-4 fw-bold">
                Novo Agendamento
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm mb-4" style="border-radius: 12px;">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card custom-card-table p-3">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="border-0">Cliente</th>
                            <th class="border-0">Profissional</th>
                            <th class="border-0">Serviço</th> {{-- Coluna de Serviço incluída --}}
                            <th class="border-0 text-center">Data</th>
                            <th class="border-0 text-center">Hora</th>
                            <th class="border-0 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendamentos as $agendamento)
                            <tr>
                                <td class="align-middle fw-bold text-dark">{{ $agendamento->cliente->nome ?? 'N/A' }}</td>
                                <td class="align-middle text-secondary">{{ $agendamento->profissional->nome ?? 'N/A' }}</td>

                                <td class="align-middle">
                                    <span class="badge bg-light text-dark border">
                                        {{ $agendamento->servico->nome ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="text-dark">
                                        {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-dark">
                                        {{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Botão Editar Customizado: Branco com contorno roxo --}}
                                        <a href="{{ route('agendamentos.edit', $agendamento->id) }}"
                                            class="btn btn-sm btn-edit-custom">
                                            Editar
                                        </a>

                                        {{-- Botão Excluir: Padrão original --}}
                                        <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST"
                                            onsubmit="return confirm('Excluir?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete-custom">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Nenhum agendamento encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection