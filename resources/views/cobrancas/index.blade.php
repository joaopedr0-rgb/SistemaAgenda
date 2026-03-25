@extends('layouts.app')


@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-800 mb-1">Gestão de Cobranças</h2>
            <p class="text-muted">Acompanhe e gerencie os pagamentos dos seus clientes.</p>
        </div>
        <button class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Nova Cobrança
        </button>
    </div>


    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Total Recebido</small>
                <h3 class="fw-800 text-success">R$ 12.450,00</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Pendente</small>
                <h3 class="fw-800 text-warning">R$ 3.200,00</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-3">
                <small class="text-uppercase fw-bold text-muted">Em Atraso</small>
                <h3 class="fw-800 text-danger">R$ 850,00</h3>
            </div>
        </div>
    </div>


    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 25px !important;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 py-3 text-muted">CLIENTE</th>
                        <th class="border-0 py-3 text-muted">VALOR</th>
                        <th class="border-0 py-3 text-muted">VENCIMENTO</th>
                        <th class="border-0 py-3 text-muted text-center">STATUS</th>
                        <th class="pe-4 border-0 py-3 text-end text-muted">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-600">João Silva</td>
                        <td class="fw-bold">R$ 150,00</td>
                        <td>10/03/2026</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Pago</span>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-light btn-sm rounded-circle"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-light btn-sm rounded-circle"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                   
                    <tr>
                        <td class="ps-4 fw-600">Maria Oliveira</td>
                        <td class="fw-bold">R$ 280,00</td>
                        <td>28/03/2026</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Pendente</span>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-primary btn-sm rounded-pill px-3">Enviar Link</button>
                        </td>
                    </tr>


                    <tr>
                        <td class="ps-4 fw-600">Carlos Souza</td>
                        <td class="fw-bold">R$ 400,00</td>
                        <td>15/03/2026</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">Atrasado</span>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-danger btn-sm rounded-pill px-3">Cobrar agora</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
    /* Estilos específicos para a área de cobrança */
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .fw-800 { font-weight: 800; }
    .fw-600 { font-weight: 600; }
   
    .table th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
   
    .table tbody tr:last-child td {
        border-bottom: 0;
    }
</style>
@endsection
