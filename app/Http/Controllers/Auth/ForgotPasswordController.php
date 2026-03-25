<?php

/*
SINTAXE: 'namespace' define a localização da classe dentro da subpasta Auth.
SEMÂNTICA: Organiza os controladores de autenticação separadamente dos controladores de negócio (como Agendamentos), seguindo as boas práticas do Laravel.
*/
namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/*
SINTAXE: Importação de Facades (Password, Hash) e Helpers (Str).
SEMÂNTICA: O 'Password' gerencia os tokens de segurança, o 'Hash' criptografa a senha para que ninguém (nem os devs) consiga lê-la no banco, e o 'Str' lida com strings complexas.
*/
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /* SINTAXE: Método showLinkRequestForm().
    SEMÂNTICA: Exibe a página onde o usuário digita o e-mail para recuperar o acesso. É a "porta de entrada" para quem esqueceu a senha.
    */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /* SINTAXE: Método sendResetLinkEmail(Request $request).
    SEMÂNTICA: Responsável por validar se o e-mail existe e disparar o e-mail com o token único de segurança. 
    Usa o 'Password::sendResetLink' para garantir que o link expire após algum tempo, aumentando a segurança.
    */
    public function sendResetLinkEmail(Request $request)
    {
        // Valida se o campo e-mail foi preenchido corretamente.
        $request->validate(['email' => 'required|email']);

        // Tenta enviar o link e captura o status do envio.
        $status = Password::sendResetLink($request->only('email'));

        // Retorna para a página anterior com uma mensagem de sucesso ou um erro amigável.
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => 'Link enviado com sucesso! Verifique seu e-mail.'])
                    : back()->withErrors(['email' => 'Não encontramos este e-mail.']);
    }

    /* SINTAXE: Método showResetForm($token). Recebe o token via URL.
    SEMÂNTICA: Exibe a tela final de redefinição. O '$token' é essencial para provar que quem está mudando a senha é a mesma pessoa que pediu o link por e-mail.
    */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token,]);
    }

    /* SINTAXE: Método reset(Request $request).
    SEMÂNTICA: O momento da troca real no banco de dados. Ele valida os dados, verifica se o token é válido e, se tudo estiver ok, atualiza a senha do usuário.
    */
    public function reset(Request $request)
    {
        /* SINTAXE: Regras de validação (confirmed e min:8).
        SEMÂNTICA: 'confirmed' exige que o usuário digite a senha duas vezes iguais. 'min:8' garante uma senha forte para proteger o salão.
        */
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        /* SINTAXE: Password::reset() com uma função anônima (Closure).
        SEMÂNTICA: O Laravel verifica o token. Se for válido, ele executa o comando 'Hash::make' para transformar a senha em um código secreto antes de salvar no banco.
        */
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // 'forceFill' atualiza o campo de senha e o 'save' grava permanentemente.
                $user->forceFill(['password' => Hash::make($password)])->save();

            }
        );

        /* SINTAXE: Operador Ternário para decidir o redirecionamento.
        SEMÂNTICA: Se o status for de sucesso, manda para o login. Se não, avisa sobre o erro (ex: link expirado ou senhas diferentes).
        */
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Senha redefinida com sucesso! Faça login com sua nova senha.')
                    : back()->withErrors(['email' => 'Erro ao redefinir a senha. Verifique se a senha confirmada é identica à senha.']);
    }
}
