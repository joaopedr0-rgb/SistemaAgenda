{{-- 
    SINTAXE: @extends('layouts.app') 
    SEMÂNTICA: Herança de template. Informa que esta view vai "preencher" as lacunas 
    do arquivo base (app.blade.php), mantendo o cabeçalho e rodapé padrão.
--}}
@extends('layouts.app')

@section('content')
<style>
     @keyframes gradientAnimation {
        0% { background-position: 20% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 20% 50%; }
    }
    /* Fundo padrão do sistema com o degradê moderno */
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
    .card-header-custom {
        background: transparent !important;
        border-bottom: 1px solid #eee !important;
        padding: 25px !important;
    }

    .card-header-custom h4 {
        color: var(--text-primary) !important;
        font-weight: 800 !important;
        margin: 0;
    }

    /* Estilização dos Rótulos e Inputs */
    .form-label {
        color: var(--text-primary) !important;
        font-weight: 700 !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-bottom: 8px;
        transition: color 0.5s ease;
      
    }

    .form-control {
        border-radius: 12px !important;
        border: 2px solid #f0f0f0 !important;
        padding: 12px !important;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #d81b60 !important;
        box-shadow: 0 0 0 0.25rem rgba(216, 27, 96, 0.1) !important;
    }

    /* Botões */
    .btn-save-custom {
        background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 10s ease infinite !important;
        border: none !important;
        color: white !important;
        font-weight: bold !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-save-custom:hover {
      transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        color: white !important;
    
    }

    .btn-cancel-custom {
        background: #f8f9fa !important;
        color: #666 !important;
        font-weight: 700 !important;
        border: 1px solid #ddd !important;
        padding: 12px 30px !important;
        border-radius: 12px !important;
        transition: all 0.3s;
    }

    .btn-cancel-custom:hover {
        background: #eee !important;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card-form">
                
                <div class="card-header-custom text-center">
                    <h4><i class="fas fa-user-tie me-2"></i>Cadastrar Novo Profissional</h4>
                </div>
                
                <div class="card-body p-4">
                    {{-- FUNCIONALIDADE MANTIDA: Rota original profissionais.store --}}
                    <form action="{{ route('profissionais.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Campo: Nome --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" 
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}" required placeholder="Ex: João Silva">
                                
                                @error('nome') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: CPF --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" name="CPF" 
                                    class="form-control @error('CPF') is-invalid @enderror" 
                                    value="{{ old('CPF') }}" required placeholder="000.000.000-00">
                                @error('CPF') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: E-mail --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" required placeholder="email@exemplo.com">
                                @error('email') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>

                            {{-- Campo: Função --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Função / Especialidade</label>
                                <input type="text" name="funcao" 
                                    class="form-control @error('funcao') is-invalid @enderror"
                                    value="{{ old('funcao') }}" required placeholder="Ex: Cabeleireiro, Dentista, etc.">
                                @error('funcao') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>
                        </div>

                        <hr class="text-light my-4">

                        <div class="d-flex justify-content-between">
                            {{-- FUNCIONALIDADE MANTIDA: Rota original para voltar --}}
                            <a href="{{ route('profissionais.index') }}" class="btn btn-cancel-custom">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            
                            <button type="submit" class="btn btn-save-custom">
                                <i class="fas fa-check-circle me-1"></i> Salvar Profissional
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection