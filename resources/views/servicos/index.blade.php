@extends('layouts.app')

@section('content')
<style>
    /* Fundo da tela acompanhando a identidade visual do sistema */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important;
        min-height: 100vh;
    }

    /* Estilo do Card da Tabela (Efeito Glass/White) */
    .custom-card-table {
        border: none !important;
        border-radius: 20px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
        overflow: hidden;
    }

    /* Cabeçalho da Tabela estilizado */
    .table thead th {
        background-color: #f8f9fa !important;
        color: #3A0256 !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #eee !important;
    }

    /* Alinhamento e cores das células */
    .table tbody td {
        vertical-align: middle !important;
        color: #444 !important;
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
        color: white !important;
    }

    /* Estilização dos botões de ação */
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
        transition: all 0.3s;
    }

    .btn-delete-custom:hover {
        background-color: #d81b60 !important;
        color: white !important;
    }

    /* Botão "+ Novo Serviço" */
    .btn-novo {
        background: white !important;
        color: #3A0256 !important;
        font-weight: 800 !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        transition: all 0.3s;
    }

    .btn-novo:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2) !important;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-white mb-0">Serviços Disponíveis</h3>
        {{-- SINTAXE: route('servicos.create') --}}
        <a href="{{ route('servicos.create') }}" class="btn btn-novo text-decoration-none">
             <i class="fas fa-plus-circle me-1"></i> Novo Serviço
        </a>
    </div>

    <div class="card custom-card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Nome do Serviço</th>
                            <th>Preço</th>
                            <th>Duração</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicos as $s)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $s->nome }}</div>
                                <small class="text-muted">ID: #{{ $s->id }}</small>
                            </td>
                            <td>
                                <span class="text-dark fw-bold">R$ {{ number_format($s->preco, 2, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="text-muted"><i class="far fa-clock me-1"></i>{{ $s->duracao }} min</span>
                            </td>
                            <td>
                                @if($s->status == 'Ativo')
                                    <span class="badge badge-ativo">Ativo</span>
                                @else
                                    <span class="badge badge-inativo">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('servicos.destroy', $s->id) }}" method="POST" class="d-inline">
                                    <a href="{{ route('servicos.edit', $s->id) }}" class="btn btn-sm btn-edit-custom me-1">
                                        Editar
                                    </a>
                                    
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-concierge-bell fa-2x d-block mb-3 opacity-50"></i>
                                Nenhum serviço cadastrado no momento.
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