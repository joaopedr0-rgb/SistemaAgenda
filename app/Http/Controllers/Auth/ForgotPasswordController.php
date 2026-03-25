<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //Exibe o formulário de "Esqueci minha senha"
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    //Envia o e-mail com o link/token de redefinição de senha
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => 'Link enviado com sucesso! Verifique seu e-mail.'])
                    : back()->withErrors(['email' => 'Não encontramos este e-mail.']);
    }

    //Exibe a tela de digitar a NOVA senha
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token,]);
    }

    //Salva a nova senha no banco de dados
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();

            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Senha redefinida com sucesso! Faça login com sua nova senha.')
                    : back()->withErrors(['email' => 'Erro ao redefinir a senha. Verifique se a senha confirmada é identica à senha.']);
    }
}
