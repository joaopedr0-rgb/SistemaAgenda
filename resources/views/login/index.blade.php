@extends('layouts.app')

@section('content')
<style>
    /* 1. O Fundo da TELA com o seu degradê Roxo e Rosa */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important; /* Garante que o fundo cubra a tela toda perfeitamente */
    }

    /* 2. Centraliza o card na tela */
    .login-container {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 15px;
    }

    /* 3. O Card Branco por cima do fundo colorido */
    .login-card {
        background-color: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3); /* Sombra um pouco maior para destacar do fundo */
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
    }

    /* 4. Título e Subtítulo (Igual anteriormente) */
    .login-card h2 {
        color: #333333;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-align: center;
        font-size: 1.8rem;
    }

    .login-card .subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    /* 5. Estilo das Labels */
    .form-label {
        font-weight: 600;
        color: #4a4a5e;
        font-size: 0.9rem;
    }

    /* 6. Estilo dos Inputs */
    .form-control {
        border-radius: 12px;
        padding: 0.8rem 1rem;
        border: 1px solid #e4e4e7;
        background-color: #fafafa;
        color: #333;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    /* Quando clica no input (Focus) */
    .form-control:focus {
        border-color: #d81b60;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(216, 27, 96, 0.15);
        outline: none;
    }

    /* 7. O Botão (Escuro para dar contraste com o card branco e combinar com o fundo) */
    .btn-submit {
        background-color: #3A0256;
        border: none;
        padding: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 12px;
        color: #ffffff;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 1rem;
        width: 100%;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background-color: #550480;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(58, 2, 86, 0.4);
        color: #ffffff;
    }

    /* Link "Esqueceu a senha" */
    .forgot-link {
        color: #d81b60;
        text-decoration: none;
        font-weight: 700;
    }
    
    .forgot-link:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <h2>Acesso ao Sistema</h2>
        <p class="subtitle">Entre com suas credenciais para continuar</p>

        <form method="POST" action="{{ route('login.authenticate') }}">
            @csrf
            
            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="exemplo@email.com" 
                    value="{{ old('email') }}" 
                    required>
                
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="••••••••" 
                    required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botão --}}
            <div class="d-grid">
                <button type="submit" class="btn-submit">
                    Entrar no Sistema
                </button>
            </div>
        </form>

        {{-- Esqueceu a Senha --}}
        <div class="text-center mt-4">
            <p class="text-muted small">
                Esqueceu sua senha? <a href="#" class="forgot-link">Clique aqui</a>
            </p>
        </div>

    </div>
</div>
@endsection