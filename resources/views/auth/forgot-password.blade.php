@extends('layouts.app')


@section('content')
<style>
    /* Usa a mesma estrutura de centralização do login */
    .reset-container {
        min-height: calc(100vh - 150px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }


    /* Usa o mesmo card do login para consistência */
    .card-reset {
        background-color: #ffffff;
        border-radius: 35px;
        box-shadow: 0 15px 45px var(--card-shadow);
        padding: 40px;
        width: 100%;
        max-width: 420px;
        border: 1px solid rgba(0,0,0,0.05);
    }


    .card-reset h2 {
        color: var(--text-main);
        font-weight: 800;
        margin-bottom: 5px;
        text-align: center;
        font-size: 1.8rem;
        letter-spacing: -1px;
    }


    .card-reset .subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 30px;
    }


    /* Labels e Inputs no padrão pílula */
    .form-label {
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        margin-left: 5px;
    }


    .form-control {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #e4e4e7;
        background-color: #fafafa;
    }


    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
    }


    /* Botão Visível e Arredondado */
    .btn-submit {
        background-color: var(--accent) !important;
        border: none;
        padding: 14px;
        font-weight: 700;
        border-radius: 50px;
        color: #ffffff !important;
        transition: 0.3s;
        text-transform: uppercase;
        font-size: 0.9rem;
        width: 100%;
        margin-top: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }


    /* Link "Voltar" */
    .back-link {
        color: var(--accent);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
    }
   
    .back-link:hover {
        text-decoration: underline;
    }


    /* Alerta de sucesso */
    .alert-success {
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        border: none;
        background-color: #d1e7dd;
        color: #0f5132;
    }
</style>


<div class="reset-container">
    <div class="card-reset">
        <h2>Recuperar Senha</h2>
        <p class="subtitle">Informe seu e-mail para receber o link de redefinição</p>


        @if (session('status'))
            <div class="alert alert-success p-3 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif


        <form method="POST" action="{{ route('password.email') }}">
            @csrf


            <div class="mb-3">
                <label for="email" class="form-label">E-mail Cadastrado</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="seu@email.com" required autofocus>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane me-2"></i> Enviar Link
            </button>
        </form>


        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left me-1"></i> Voltar para o Login
            </a>
        </div>
    </div>
</div>
@endsection
