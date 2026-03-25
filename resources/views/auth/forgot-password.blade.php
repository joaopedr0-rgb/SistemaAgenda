@extends('layouts.app')



@section('content')
{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Salão de Beleza</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

    <div class="container-forgot">
        <div class="card-forgot">
            <h2>Esqueceu sua senha?</h2>
            <p>Não se preocupe! Informe seu e-mail abaixo e enviaremos um link para você criar uma nova senha.</p>

            @if (session('status'))
                <div class="alert alert-success" style="color: green; margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail cadastrado:</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="exemplo@gmail.com">
                </div>

                <button type="submit" class="btn-primary">Enviar Link de Recuperação</button>
            </form>

            <div class="footer-link">
                <a href="{{ route('login') }}">Voltar para o Login</a>
            </div>
        </div>
    </div>

</body>
</html>