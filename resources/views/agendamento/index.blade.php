@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">Agendamentos</h3>
        <a href="{{ route('agendamentos.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Agendamento
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="py-3">Profissional</th>
                            <th class="py-3">Data</th>
                            <th class="py-3">Hora</th>
                            <th class="py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendamentos as $agendamento)
                        <tr>
                            <td class="px-4 fw-bold">{{ $agendamento->cliente->nome ?? 'N/A' }}</td>
                            <td>{{ $agendamento->profissional->nome ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                    
                                    <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Nenhum agendamento encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection