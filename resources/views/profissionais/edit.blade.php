@extends('layouts.app')

@section('content')
<style>
     @keyframes gradientAnimation {
        0% { background-position: 20% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 20% 50%; }
    }
    /* Fundo degradê idêntico ao das outras telas */
   body {
      background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 15s ease infinite !important;
        background-attachment: fixed !important;
        min-height: 100vh;
        transition: background 0.5s ease;
    }
     .custom-card-form {
        border: none !important;
        border-radius: 20px !important;
        color: var(--text-primary) !important;
        transition: color 0.5s ease;
        backdrop-filter: blur(5px);
    }

    .form-label {
        color: #3A0256;
        font-weight: 700;
    }

    /* Botão Atualizar: Azul conforme seu padrão */
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
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card-form">
                <div class="card-header bg-transparent border-0 pt-4 px-4 text-center">
                    <h4 class="mb-0 fw-bold" style="color: #3A0256;">Editar Profissional: {{ $profissional->nome }}</h4>
                </div>
                
                <div class="card-body p-4">
                    {{-- Rota e ID originais preservados --}}
                    <form action="{{ route('profissionais.update', $profissional->id) }}" method="POST">
                        @csrf
                        {{-- SINTAXE: @method('PUT') - Mantida a funcionalidade original --}}
                        @method('PUT')

                        <div class="row">
                            {{-- Nome Completo --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome', $profissional->nome) }}" required>
                                @error('nome') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>

                            {{-- CPF --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" name="CPF" class="form-control @error('CPF') is-invalid @enderror" 
                                    value="{{ old('CPF', $profissional->CPF) }}" required>
                                @error('CPF') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>

                            {{-- E-mail --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $profissional->email) }}" required>
                                @error('email') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>

                            {{-- Função / Especialidade --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Função / Especialidade</label>
                                <input type="text" name="funcao" class="form-control @error('funcao') is-invalid @enderror"
                                    value="{{ old('funcao', $profissional->funcao) }}" required>
                                @error('funcao') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Botão Voltar original --}}
                            <a href="{{ route('profissionais.index') }}" class="btn btn-light px-4 fw-bold text-secondary text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>
                            {{-- Botão Atualizar original --}}
                            <button type="submit" class="btn btn-update-custom">
                                <i class="fas fa-save me-1"></i> Atualizar Dados
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection