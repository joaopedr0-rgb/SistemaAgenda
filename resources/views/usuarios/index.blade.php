@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: var(--nav-bg)">Gerenciar Usuários</h3>
        <a href="{{ route('usuarios.create') }}" class="btn btn-novo shadow-sm">
            <i class="fas fa-user-shield me-2"></i> Novo Usuário
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
                        <th class="ps-4 py-3">ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data de Cadastro</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $us)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $us->id }}</td>
                            <td class="fw-bold">{{ $us->name }}</td>
                            <td>{{ $us->email }}</td>
                            <td>
                                <i class="far fa-calendar-alt me-1 text-muted"></i>
                                {{ $us->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('usuarios.edit', $us->id) }}" class="btn btn-sm btn-edit-custom me-1">Editar</a>
                                <form action="{{ route('usuarios.destroy', $us->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">Nenhum usuário cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection