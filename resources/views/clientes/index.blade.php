@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: var(--nav-bg)">Clientes Registrados</h3>
        <a href="{{ route('clientes.create') }}" class="btn btn-novo shadow-sm">
            <i class="fas fa-user-plus me-2"></i> Novo Cliente
        </a>
    </div>

    <div class="card custom-card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 py-3">Nome / ID</th>
                        <th>Contato (E-mail/Tel)</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $cliente->nome }}</div>
                                <small class="text-muted">ID: #{{ $cliente->id }}</small>
                            </td>
                            <td>
                                <div>{{ $cliente->email }}</div>
                                <small class="text-muted">{{ $cliente->telefone ?? 'Sem telefone' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $cliente->status == 'ativo' ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                    {{ ucfirst($cliente->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-edit-custom me-1">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Excluir?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">Nenhum cliente cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection