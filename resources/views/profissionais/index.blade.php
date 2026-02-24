@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Profissionais</h3>
        {{-- SINTAXE: route('profissionais.create') --}}
        {{-- SEMÂNTICA: Gera a URL amigável para o formulário de cadastro --}}
        <a href="{{ route('profissionais.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Profissional
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Função</th>
                        <th>Status</th>
                        <th class="text-end px-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- SINTAXE: @foreach ($profissionais as $profissional) --}}
                    {{-- SEMÂNTICA: Laço de repetição que percorre a coleção enviada pelo Controller --}}
                    @forelse ($profissionais as $p)
                        <tr>
                            <td class="px-4">{{ $p->nome }}</td>
                            <td>{{ $p->CPF }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->funcao }}</td>
                            <td>
                                {{-- Lógica simples para cores de status --}}
                                <span class="badge {{ $p->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                {{-- Link para Edição passando o ID do objeto --}}
                                <a href="{{ route('profissionais.edit', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                {{-- SEMÂNTICA: Exclusão exige um formulário oculto por questões de segurança (verbo DELETE) --}}
                                <form action="{{ route('profissionais.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este profissional?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Nenhum profissional cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection