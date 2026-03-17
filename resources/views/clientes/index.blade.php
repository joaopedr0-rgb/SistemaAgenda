@extends('layouts.app')

@section('content')
    <style>
        /* Fundo da tela acompanhando o tema */
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

        /* Fundo da Dashboard acompanhando o tema */
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

        /* Estilo do Card da Tabela */
        .custom-card-table {
            color: var(--text-primary) !important;
            border: none !important;
            border-radius: 20px !important;
            overflow: hidden;
            backdrop-filter: blur(5px);
            transition: color 0.5s ease;
        }

        /* Cabeçalho da Tabela */
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

        /* Botões de Ação */
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
            color: var(--text-primary) !important;
            border: 1px solid var(--text-primary) !important;
            font-weight: 600 !important;
            transition: all 0.3s;
        }

        .btn-delete-custom:hover {
            background-color: var(--text-primary) !important;
            color: white !important;
        }

        /* Botão "+ Novo" */
        .btn-novo {
            background: white !important;
            color: var(--text-primary) !important;
            font-weight: 800 !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 10px 20px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s;
        }

        .btn-novo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2) !important;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-white mb-0">Clientes Registrados</h3>
            <a href="{{ route('clientes.create') }}" class="btn btn-novo">
                <i class="fas fa-plus-circle mr-2"></i> Novo Cliente
            </a>
        </div>

        <div class="card custom-card-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 py-3">Nome</th>
                                <th>Contato</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $cliente->nome }}</div>
                                        <small class="text-muted">ID: #{{ $cliente->id }}</small>
                                    </td>
                                    <td>
                                        <div><i class="far fa-envelope text-muted me-1"></i> {{ $cliente->email }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-phone-alt text-muted me-1"></i>
                                            {{ $cliente->telefone ?? 'Sem telefone' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $cliente->status == 'ativo' ? 'badge-ativo' : 'badge-inativo' }}">
                                            {{ ucfirst($cliente->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                            class="d-inline">
                                            <a href="{{ route('clientes.edit', $cliente->id) }}"
                                                class="btn btn-sm btn-edit-custom me-1">
                                                Editar
                                            </a>

                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete-custom"
                                                onclick="return confirm('Excluir este cliente?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-users-slash fa-2x d-block mb-3 opacity-50"></i>
                                        Nenhum cliente cadastrado no momento.
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