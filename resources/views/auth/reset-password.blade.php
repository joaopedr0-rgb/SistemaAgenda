@extends('layouts.app')


@section('content')
<style>
    /* Centralização perfeita na tela */
    .reset-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }


    /* Card seguindo o padrão de 35px e sombra leve */
    .card-reset {
        background: #ffffff;
        padding: 40px;
        border-radius: 35px;
        box-shadow: 0 15px 45px var(--card-shadow);
        width: 100%;
        max-width: 450px;
        border: 1px solid rgba(0,0,0,0.05);
    }


    .card-reset h2 {
        color: var(--text-main);
        font-weight: 800;
        text-align: center;
        letter-spacing: -1px;
        margin-bottom: 10px;
    }


    .subtitle {
        text-align: center;
        font-size: 14px;
        color: #666;
        margin-bottom: 30px;
    }


    /* Labels e Inputs no estilo Clean */
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
        color: var(--text-main);
        padding-left: 5px;
    }


    .form-control {
        border-radius: 50px !important;
        padding: 12px 20px !important;
        border: 1px solid #e4e4e7 !important;
        background-color: #fdfdfd !important;
        margin-bottom: 5px;
    }


    .form-control:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1) !important;
    }


    /* O botão que você consegue enxergar agora */
    .btn-submit {
        width: 100%;
        padding: 14px;
        background-color: var(--accent) !important;
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-top: 15px;
    }


    .btn-submit:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }


    .error-msg {
        color: #dc3545;
        font-size: 12px;
        padding-left: 15px;
        font-weight: 600;
    }
</style>


<div class="reset-container">
    <div class="card-reset">
        <h2>Nova Senha</h2>
        <p class="subtitle">Crie uma senha forte para proteger sua conta no Schedule Online.</p>


        <form action="{{ route('password.update') }}" method="POST">
            @csrf
           
            {{-- Token obrigatório para o Laravel processar o reset --}}
            <input type="hidden" name="token" value="{{ $token }}">


            <div class="mb-3">
                <label class="form-label" for="email">Confirme seu E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ request()->email }}" required placeholder="seu@email.com">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>


            <div class="mb-3">
                <label class="form-label" for="password">Nova Senha</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Mínimo 8 caracteres">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>


            <div class="mb-4">
                <label class="form-label" for="password_confirmation">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repita a senha">
            </div>


            <button type="submit" class="btn-submit">
                <i class="fas fa-key me-2"></i> Salvar Nova Senha
            </button>
        </form>
    </div>
</div>
@endsection
