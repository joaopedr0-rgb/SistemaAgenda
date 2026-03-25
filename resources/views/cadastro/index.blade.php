@extends('layouts.app')


@section('content')
<style>
    /* 1. O Fundo da TELA - Agora limpo como o resto do sistema */
    body {
        background-color: var(--bg-body) !important;
    }


    /* 2. Centraliza o card na tela */
    .cadastro-container {
        min-height: calc(100vh - 150px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 15px;
    }


    /* 3. O Card Branco - Seguindo o padrão de 35px de arredondamento */
    .cadastro-card {
        background-color: #ffffff;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 35px;
        box-shadow: 0 15px 45px var(--card-shadow);
        padding: 2.5rem;
        width: 100%;
        max-width: 850px;
    }


    /* 4. Título e Subtítulo */
    .cadastro-card h2 {
        color: var(--text-main);
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-align: center;
        font-size: 1.8rem;
        letter-spacing: -1px;
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
        color: var(--text-main);
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        margin-left: 5px;
    }


    /* 6. Estilo dos Inputs - Arredondados estilo Pílula */
    .form-control {
        border-radius: 50px;
        padding: 0.7rem 1.2rem;
        border: 1px solid #e4e4e7;
        background-color: #fdfdfd;
        color: #333;
        transition: all 0.3s ease;
    }


    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        outline: none;
    }


    /* 7. O Botão - Agora usa a cor --accent que você enxerga bem */
    .btn-submit {
        background-color: var(--accent) !important;
        border: none;
        padding: 14px;
        font-weight: 700;
        border-radius: 50px;
        color: #ffffff !important;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 0.9rem;
        width: 100%;
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }


    .btn-submit:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }


    /* Link voltar */
    .back-link {
        color: var(--accent);
        text-decoration: none;
        font-weight: 700;
    }
   
    .back-link:hover {
        text-decoration: underline;
    }


    hr {
        opacity: 0.1;
    }
</style>


<div class="cadastro-container">
    <div class="cadastro-card">
        <h2>Criar Nova Conta</h2>
        <p class="subtitle">Preencha seus dados para acessar o Schedule Online</p>


        <form method="POST" action="{{ route('cadastro') }}">
            @csrf


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Ex: João Silva" required autofocus>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail Profissional</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="seu@email.com" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha" required>
                </div>
            </div>


            <hr class="my-4">


            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" maxlength="9" placeholder="00000-000" required>
                    @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-7 mb-3">
                    <label for="logradouro" class="form-label">Logradouro</label>
                    <input type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" placeholder="Rua, Av..." required>
                    @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label for="numero" class="form-label">Nº</label>
                    <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" placeholder="123" required>
                    @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" placeholder="Seu bairro" required>
                    @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" placeholder="Sua cidade" required>
                    @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2 mb-4">
                    <label for="estado" class="form-label">UF</label>
                    <input type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado" maxlength="2" placeholder="MG" required>
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
                Já possui uma conta? <a href="{{ route('login') }}" class="back-link">Faça login agora</a>
            </p>
        </div>


    </div>
</div>
@endsection
