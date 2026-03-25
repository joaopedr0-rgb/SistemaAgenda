@extends('layouts.app')

@section('content')
<style>
    /* 1. O Fundo da TELA com o seu degradê Roxo e Rosa */
    body {
        background: linear-gradient(135deg, #3A0256 0%, #d81b60 100%) !important;
        background-attachment: fixed !important;
    }

    /* 2. Centraliza o card na tela */
    .cadastro-container {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 15px;
    }

    /* 3. O Card Branco (Mais largo para acomodar colunas e não ficar gigante para baixo) */
    .cadastro-card {
        background-color: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        padding: 2.5rem;
        width: 100%;
        max-width: 800px; /* Mais largo que o login */
    }

    /* 4. Título e Subtítulo */
    .cadastro-card h2 {
        color: #333333;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-align: center;
        font-size: 1.8rem;
    }

    .cadastro-card .subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    /* 5. Estilo das Labels */
    .form-label {
        font-weight: 600;
        color: #4a4a5e;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    /* 6. Estilo dos Inputs */
    .form-control {
        border-radius: 10px; /* Um pouco mais sutil que o login */
        padding: 0.7rem 1rem;
        border: 1px solid #e4e4e7;
        background-color: #fafafa;
        color: #333;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .form-control:focus {
        border-color: #d81b60;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(216, 27, 96, 0.15);
        outline: none;
    }

    /* 7. O Botão */
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
        margin-top: 1rem;
    }

    .btn-submit:hover {
        background-color: #550480;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(58, 2, 86, 0.4);
        color: #ffffff;
    }

    /* Link voltar */
    .back-link {
        color: #d81b60;
        text-decoration: none;
        font-weight: 700;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="cadastro-container">
    <div class="cadastro-card">
        <h2>Criar Nova Conta</h2>
        <p class="subtitle">Preencha seus dados abaixo para se cadastrar</p>

        <form method="POST" action="{{ route('cadastro') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required autofocus>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            <hr class="my-4" style="border-color: #e4e4e7;">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" maxlength="9" value="{{ old('cep') }}" required>
                    @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-7 mb-3">
                    <label for="logradouro" class="form-label">Logradouro</label>
                    <input type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" value="{{ old('logradouro') }}" required>
                    @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" value="{{ old('numero') }}" required>
                    @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') }}" required>
                    @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') }}" required>
                    @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2 mb-4">
                    <label for="estado" class="form-label">UF</label>
                    <input type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado" maxlength="2" value="{{ old('estado') }}" required>
                    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <button type="submit" class="btn-submit">
                        Finalizar Cadastro
                    </button>
                </div>
            </div>

        </form>

        <div class="text-center mt-4">
            <p class="subtitle small mb-0">
                Já possui uma conta? <a href="{{ route('login') }}" class="back-link">Faça login</a>
            </p>
        </div>

    </div>
</div>

@endsection