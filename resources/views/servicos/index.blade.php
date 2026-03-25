@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: var(--nav-bg)">Serviços Disponíveis</h3>
        <a href="{{ route('servicos.create') }}" class="btn btn-novo shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> Novo Serviço
        </a>
    </div>

    <div class="card custom-card-table">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 py-3">Nome do Serviço</th>
                        <th>Preço</th>
                        <th>Comissão</th>
                        <th>Duração</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicos as $s)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $s->nome }}</div>
                                <small class="text-muted">ID: #{{ $s->id }}</small>
                            </td>
                            <td><span class="fw-bold">R$ {{ number_format($s->preco, 2, ',', '.') }}</span></td>
                            <td>{{ $s->comissao }}%</td>
                            <td><i class="far fa-clock me-1 text-muted"></i>{{ $s->duracao }} min</td>
                            <td class="text-center">
                                <span class="badge {{ $s->status == 'Ativo' ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('servicos.edit', $s->id) }}" class="btn btn-sm btn-edit-custom me-1">Editar</a>
                                <form action="{{ route('servicos.destroy', $s->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-custom" onclick="return confirm('Excluir serviço?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">Nenhum serviço cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection