@extends ('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary">Serviços</h3>
            {{-- SINTAXE: route('servicos.create') --}}
            {{-- SEMÂNTICA: Gera a URL amigável para o formulário de cadastro --}}
            <a href="{{ route('servicos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Serviço
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Nome</th>
                            <th>Preço</th>
                            <th>Duração</th>
                            <th>Status</th> {{-- COLUNA ADICIONADA --}}
                            <th class="text-end px-4">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($servicos as $s)
                            <tr>
                                <td class="px-4">{{ $s->nome }}</td>
                                <td>R$ {{ number_format($s->preco, 2, ',', '.') }}</td> {{-- Melhoria de exibição do preço --}}
                                <td>{{ $s->duracao }} min</td>
                                
                                {{-- Exibição do Status com cor --}}
                                <td>
                                    @if($s->status == 'Ativo')
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-secondary">Inativo</span>
                                    @endif
                                </td>

                                <td class="text-end px-4">
                                    {{-- Link para Edição passando o ID do objeto --}}
                                    <a href="{{ route('servicos.edit', $s->id) }}" class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    <form action="{{ route('servicos.destroy', $s->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Nenhum serviço cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection