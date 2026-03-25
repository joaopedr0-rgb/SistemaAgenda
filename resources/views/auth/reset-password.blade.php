{{-- resources/views/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha - Salão de Beleza</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Reutilizando o estilo que te mandei antes */
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card-reset { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-primary { width: 100%; padding: 12px; background: #ff69b4; border: none; border-radius: 8px; color: white; font-weight: bold; cursor: pointer; }
        .error-msg { color: red; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="card-reset">
        <h2>Criar Nova Senha</h2>
        <p style="text-align: center; font-size: 14px; color: #666;">Crie uma senha forte para proteger sua conta.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Confirme seu E-mail:</label>
                <input type="email" name="email" id="email" value="{{ request()->email }}" required placeholder="seu@email.com">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Nova Senha:</label>
                <input type="password" name="password" id="password" required placeholder="Mínimo 8 caracteres">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nova Senha:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Repita a senha">
            </div>

            <button type="submit" class="btn-primary">Salvar Nova Senha</button>
        </form>
    </div>

</body>
</html>