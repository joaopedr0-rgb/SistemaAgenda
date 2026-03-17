@extends('layouts.app')

@section('content')
<style>
    /* Fundo degradê idêntico ao das outras telas */
    @keyframes gradientAnimation {
        0% { background-position: 20% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 20% 50%; }
    }
    /* Fundo da Dashboard acompanhando o tema */
    body {
        background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 15s ease infinite !important;
        background-attachment: fixed !important;
        min-height: 100vh;
        transition: background 0.5s ease;
    }
     .custom-card-form {
        color: var(--text-primary) !important;
        transition: color 0.5s ease;
    }
    .form-label {
       color: var(--text-primary) !important; /* Puxa a cor do tema atual */
        transition: color 0.5s ease;
        font-weight: 700;
    }

    /* Botão Azul de Ação Principal */
    .btn-update-custom {
       background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 10s ease infinite !important;
        border: none !important;
        color: white !important;
        font-weight: bold !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
       
    }
    .btn-update-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        color: white !important;
    }

    .form-control:focus {
        border-color: #3A0256;
        box-shadow: 0 0 0 0.25 margin rgba(58, 2, 86, 0.1);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card custom-card-form">
                <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                    {{-- SINTAXE: $cliente->nome --}}
                    <h4 class="mb-0 fw-bold" style="color: #3A0256;">Editar Cliente: {{ $cliente->nome }}</h4>
                </div>

                <div class="card-body p-4">
                    {{-- Rota original preservada --}}
                    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                        @csrf
                        {{-- SINTAXE: @method('PUT') para conformidade RESTful --}}
                        @method('PUT')

                        <div class="row">
                            {{-- Nome Completo --}}
                            <div class="col-md-12 mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" name="nome" id="nome" 
                                    class="form-control @error('nome') is-invalid @enderror" 
                                    value="{{ old('nome', $cliente->nome) }}" required>
                                @error('nome')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- E-mail --}}
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $cliente->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Telefone --}}
                            <div class="col-md-12 mb-4">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" 
                                    class="form-control @error('telefone') is-invalid @enderror" 
                                    value="{{ old('telefone', $cliente->telefone) }}"
                                    placeholder="(00) 00000-0000">
                                @error('telefone')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Botão Voltar/Cancelar original --}}
                            <a href="{{ route('clientes.index') }}" class="btn btn-light px-4 fw-bold text-secondary text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Cancelar
                            </a>
                            {{-- Botão de submissão original --}}
                            <button type="submit" class="btn btn-update-custom">
                                <i class="fas fa-save me-1"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection