@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">Bem-vindo ao Dashboard</h2>
        <p class="text-muted">Resumo da sua agenda para hoje.</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3 border-start border-primary border-4">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small fw-bold">Total de Clientes</h6>
                <h2 class="mb-0">124</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 border-start border-success border-4">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small fw-bold">Agendamentos Hoje</h6>
                <h2 class="mb-0">12</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 border-start border-warning border-4">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small fw-bold">Aguardando Confirmação</h6>
                <h2 class="mb-0">5</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">Próximos Agendamentos</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Horário</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>09:00</td>
                            <td>João Silva</td>
                            <td>Corte de Cabelo</td>
                            <td><span class="badge bg-success">Confirmado</span></td>
                        </tr>
                        <tr>
                            <td>10:30</td>
                            <td>Maria Souza</td>
                            <td>Barba e Cabelo</td>
                            <td><span class="badge bg-warning">Pendente</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection