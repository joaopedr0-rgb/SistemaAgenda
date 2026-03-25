@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: var(--nav-bg)">Gestão de Profissionais</h3>
        <a href="{{ route('profissionais.create') }}" class="btn btn-novo shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> Novo Profissional
        </a>
    </div>

    <div class="card custom-card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Função</th>
                        <th class="text-center">Status</th>
                        <th class="text-end px-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profissionais as $p)
                        <tr>
                            <td class="px-4 fw-bold">{{ $p->nome }}</td>
                            <td>{{ $p->CPF }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->funcao }}</td>
                            <td class="text-center">
                                <span class="badge {{ $p->status == 'ativo' ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <a href="{{ route('profissionais.edit', $p->id) }}" class="btn btn-sm btn-edit-custom">Editar</a>
                                <form action="{{ route('profissionais.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Excluir?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">Nenhum profissional cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection