@extends('layouts.app')

@section('content')
<style>
    /* Estilização específica para centralizar o card verticalmente se necessário */
    .login-container {
        min-height: calc(100vh - 200px); /* Desconta o espaço da navbar/footer */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .btn-primary {
        background-color: var(--bs-primary);
        border: none;
        padding: 12px;
        font-weight: 600;
        border-radius: 10px;
    }
</style>

<div class="login-container">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">Acesso ao Sistema</h4>
                    <p class="text-muted small">Entre com suas credenciais para continuar</p>
                </div>

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
                            required
                        >
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
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botão --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            Entrar no Sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <p class="text-muted small">Esqueceu sua senha? <a href="#" class="text-decoration-none">Clique aqui</a></p>
        </div>
    </div>
</div>
@endsection