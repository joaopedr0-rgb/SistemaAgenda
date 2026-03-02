
@extends('layouts.app')


@section('content')
    
    <div class="d-flex align-items-center justify-content-center">
        <div class="card shadow-sm p-4 border-0 w-100" style="max-width: 450px;">
            <h2 class="text-center mb-4 fw-bold text-dark">Criar Nova Conta</h2>

            {{-- Exibição de Erros --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulário Apontando para o Controller --}}
            <form action="{{ route('cadastro') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold text-secondary">Nome Completo</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-secondary">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold text-secondary">Senha</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold text-secondary">Confirmar Senha</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                    Cadastrar
                </button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-muted mb-0">Já tem uma conta? 
                    <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">
                        Faça login aqui
                    </a>
                </p>
            </div>
        </div>
    </div>

@endsection