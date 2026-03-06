@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Usuarios</h2>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nova Usuarios
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $us)
                            <tr>
                                <td>{{ $us->id }}</td>
                                <td>{{ $us->name }}</td>
                                <td>{{ $us->email }}</td>
                                <td>{{ $us->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $us->id) }}"
                                        class="btn btn-sm btn-warning">Editar</a>
                                    {{-- Botão de excluir pode ser adicionado aqui --}}
                                </td>
                                <td>
                                    <form action="{{ route('usuarios.destroy', $us->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem a certeza que deseja excluir esta recepcionista? Esta ação não pode ser desfeita.')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum Usuario cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection