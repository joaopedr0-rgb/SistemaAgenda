@extends('layouts.app')

@section('content')
<style>
    /* Fundo padrão com degradê moderno */
   e>
     @keyframes gradientAnimation {
        0% { background-position: 20% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 20% 50%; }
    }
    /* Fundo da tela acompanhando o tema */
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
        color: #3A0256 !important;
        font-weight: 800 !important;
        margin: 0;
    }

    /* Estilização dos Rótulos e Inputs */
    .form-label {
        color: var(--text-primary) !important; /* Puxa a cor do tema atual */
        transition: color 0.5s ease;
        font-weight: 700 !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px !important;
        border: 2px solid #f0f0f0 !important;
        padding: 12px !important;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--text-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(216, 27, 96, 0.1) !important;
    }

    /* Botões Customizados */
    .btn-edit-custom {
          background: var(--bg-gradient) !important;
        background-size: 400% 400% !important;
        animation: gradientAnimation 10s ease infinite !important;
        border: none !important;
        color: white !important;
        font-weight: bold !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-edit-custom:hover {
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

    .text-helper {
        font-size: 0.8rem;
        color: #d81b60;
        font-style: italic;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom-card-form">
                
                <div class="card-header-custom text-center">
                    <h4><i class="fas fa-user-edit me-2"></i>Editar Usuário: {{ $user->name }}</h4>
                </div>
                
                <div class="card-body p-4">
                    {{-- FUNCIONALIDADE MANTIDA: Rota original usuarios.update e método PUT --}}
                    <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nome Completo --}}
                        <div class="mb-4">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') 
                                <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                            @enderror
                        </div>

                        {{-- E-mail --}}
                        <div class="mb-4">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') 
                                <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                            @enderror
                        </div>

                        {{-- Seção de Senha --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label">
                                    Nova Senha 
                                    <span class="text-helper d-block">(deixe em branco para manter)</span>
                                </label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password') 
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Nova Senha
                                    <span class="text-helper d-block">&nbsp;</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        {{-- Botões de Ação --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-cancel-custom text-decoration-none">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-edit-custom">
                                <i class="fas fa-sync-alt me-1"></i> Atualizar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection