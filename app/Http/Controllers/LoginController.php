<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço da classe. Permite o carregamento automático (autoload) pelo Laravel.
 */
namespace App\Http\Controllers;

// SINTAXE: use
// SEMÂNTICA: Importa o model User (embora a autenticação o use por baixo dos panos) e a classe Request para lidar com os dados recebidos.
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * SINTAXE: public function index()
     * SEMÂNTICA: Método acessado via GET (ex: /login). 
     * Sua única função é mostrar a tela inicial para o usuário digitar os dados.
     */
    public function index()
    {
        // SINTAXE: return view('caminho.da.view');
        // SEMÂNTICA: Renderiza o arquivo resources/views/login/index.blade.php contendo o formulário HTML.
        return view('login.index');
    }

    /**
     * SINTAXE: public function authenticate(Request $request)
     * SEMÂNTICA: Método acessado via POST. Recebe os dados preenchidos no form, valida e tenta "logar" o usuário.
     */
    public function authenticate(Request $request)
    {
        /*
         * SINTAXE: $request->validate([ 'campo' => ['regras'] ])
         * SEMÂNTICA: Garante que o usuário digitou um e-mail com formato válido e não deixou a senha em branco.
         * O array retornado ($credentials) fica assim: ['email' => 'joao@email.com', 'password' => '123456'].
         */
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /*
         * SINTAXE: auth()->attempt($array_de_credenciais)
         * SEMÂNTICA: A Mágica do Laravel! O helper 'auth()' acessa a fachada de autenticação. 
         * O 'attempt()' vai no banco buscar o e-mail. Se achar, ele pega a senha digitada, faz o "hash" (criptografa) 
         * e compara com o hash salvo no banco. Se tudo bater perfeitamente, loga o usuário na sessão e retorna 'true'.
         */
        if (auth()->attempt($credentials)) {
            
            /*
             * SINTAXE: $request->session()->regenerate()
             * SEMÂNTICA: Segurança Extrema (Prevenção contra 'Session Fixation'). 
             * Ao logar com sucesso, o Laravel destrói o ID da sessão antiga e cria um novo, garantindo que um hacker 
             * que por acaso tenha roubado o ID anterior não consiga acessar o sistema autenticado.
             */
            $request->session()->regenerate();

            /*
             * SINTAXE: redirect()->intended('/rota_padrao')
             * SEMÂNTICA: Redirecionamento Inteligente. Se o usuário tentou acessar '/profissionais', 
             * foi barrado por não estar logado e mandado pro login, o 'intended' lembra disso e o joga 
             * de volta para '/profissionais'. Se ele veio direto para o login, cai na rota padrão.
             */
            return redirect()->intended('/dashboard');
        }

        /*
         * SINTAXE: back()->withErrors([ 'chave' => 'mensagem' ])
         * SEMÂNTICA: Se o 'if' do attempt() falhar (e-mail não existe ou senha errada), o código continua aqui.
         * O 'back()' joga o usuário de volta para a tela de login. O 'withErrors' manda uma mensagem de erro 
         * genérica (boa prática de segurança para não avisar ao hacker se o que ele errou foi o e-mail ou a senha).
         */
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    /**
     * SINTAXE: public function logout(Request $request)
     * SEMÂNTICA: Método para encerrar a sessão (Sair/Logoff).
     */
    public function logout(Request $request)
    {
        /*
         * SINTAXE: auth()->logout()
         * SEMÂNTICA: Remove o "status" de autenticado do usuário no sistema. Ele volta a ser um visitante anônimo.
         */
        auth()->logout();
        
        /*
         * SINTAXE: $request->session()->invalidate()
         * SEMÂNTICA: Destrói completamente o arquivo/registro de sessão atual (limpa carrinhos, variáveis temporárias, etc).
         */
        $request->session()->invalidate();
        
        /*
         * SINTAXE: $request->session()->regenerateToken()
         * SEMÂNTICA: Segurança (Prevenção contra 'Cross-Site Request Forgery - CSRF'). 
         * Gera um novo token de formulários para a aplicação, garantindo que a sessão velha está totalmente morta.
         */
        $request->session()->regenerateToken();

        /*
         * SINTAXE: redirect('/login')
         * SEMÂNTICA: Manda o usuário de volta para a tela inicial após sair.
         */
        return redirect('/login');
    }

    /**
     * SINTAXE/SEMÂNTICA: Como este Controller provavelmente foi criado pelo terminal usando a flag '--resource' 
     * (php artisan make:controller LoginController --resource), o Laravel gerou esses métodos de CRUD (show, edit, update, destroy). 
     * Porém, como um Controller de Login trata apenas de sessão e não de CRUD completo, eles não são usados e ficam vazios.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}