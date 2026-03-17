L
@extends('layouts.app')

@section('content')
<style>
    /* Fundo padrão do sistema */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh;
    }

    /* Card da Tabela com transparência leve */
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

    /* Estilo para a data */
    .date-text {
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Botão Editar */
    .btn-edit-custom {
        color: #3A0256 !important;
        border: 1px solid #3A0256 !important;
        font-weight: 600 !important;
        transition: all 0.3s;
        border-radius: 8px !important;
    }

    .btn-edit-custom:hover {
        background-color: #3A0256 !important;
        color: white !important;
    }

    /* Botão Excluir */
    .btn-delete-custom {
        color: #d81b60 !important;
        border: 1px solid #d81b60 !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
    }

    .btn-delete-custom:hover {
        background-color: #d81b60 !important;
        color: white !important;
    }

    /* Botão Novo Usuario */
    .btn-novo {
        background: white !important;
        color: #3A0256 !important;
        font-weight: 800 !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        border: none !important;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-white mb-0">Gerenciar Usuários</h3>
        <a href="{{ route('usuarios.create') }}" class="btn btn-novo text-decoration-none">
            <i class="fas fa-plus-circle me-1"></i> Nova Usuarios
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card custom-card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de Cadastro</th>
                            <th class="text-end px-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $us)
                            <tr>
                                <td class="px-4 text-muted">#{{ $us->id }}</td>
                                <td class="fw-bold text-dark">{{ $us->name }}</td>
                                <td>{{ $us->email }}</td>
                                <td class="date-text">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $us->created_at->format('d/m/Y') }}
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('usuarios.edit', $us->id) }}" class="btn btn-sm btn-edit-custom">
                                            Editar
                                        </a>

                                        <form action="{{ route('usuarios.destroy', $us->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete-custom"
                                                onclick="return confirm('Tem a certeza que deseja excluir esta recepcionista? Esta ação não pode ser desfeita.')">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-2x d-block mb-3 opacity-50"></i>
                                    Nenhum Usuario cadastrada.
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