<?php

/*
 * SINTAXE: use ...
 * SEMÂNTICA: Muito bem, Bernardo! Aqui você está importando as classes de todos os seus Controllers 
 * para que este arquivo de rotas saiba exatamente onde procurar a lógica de cada URL.
 */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AgendamentosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal: assim que o sistema abre (localhost:8000), redireciona direto para o cadastro
/*
 * SINTAXE: Route::get('/', function () { ... })
 * SEMÂNTICA: Bernardo, o uso do 'redirect()->route()' aqui é uma excelente prática. 
 * Caso você mude a URL do cadastro no futuro, esse redirecionamento inteligente não vai quebrar.
 */
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Aqui, Bernardo, é toda a parte de login e cadastro. Estas rotas estão fora do middleware de autenticação porque o usuário precisa acessar elas sem estar logado.
/*
 * SINTAXE: Route::get(...) / Route::post(...)
 * SEMÂNTICA: Você definiu as portas de entrada públicas do seu sistema perfeitamente. 
 * O GET exibe o formulário para o usuário, e o POST processa os dados de forma invisível e segura.
 */
Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Aqui estão as rotas protegidas por autenticação, ou seja, o usuário precisa estar logado para acessar essas páginas.
/*
 * SINTAXE: Route::middleware(['auth'])->group(...)
 * SEMÂNTICA: Excelente "muro de contenção", Bernardo. O middleware 'auth' nativo do Laravel 
 * blinda o grupo abaixo. Se alguém sem login tentar acessar '/clientes', será barrado e enviado ao login.
 */
Route::middleware(['auth'])->group(function () {
    
    /*
     * SINTAXE: Route::resource('nome', Controller::class)
     * SEMÂNTICA: A mágica do Laravel! Com uma linha, você gerou as 7 rotas CRUD.
     * E o detalhe de ouro, Bernardo: usando ->parameters(['clientes' => 'cliente']), você corrigiu 
     * a tentativa do framework de adivinhar o singular, mantendo sua URL em português impecável.
     */
    Route::resource('clientes', ClientesController::class)->parameters(['clientes' => 'cliente']);
    Route::resource('servicos', ServicosController::class)->parameters(['servicos' => 'servico']);
    Route::resource('agendamentos', AgendamentosController::class)->parameters(['agendamentos' => 'agendamento']);
    
});


// Aqui estão as rotas protegidas por autenticação e autorização, ou seja, o usuário precisa estar logado e ser um administrador para acessar essas páginas.
/*
 * SINTAXE: Route::middleware(['auth', 'admin'])->group(...)
 * SEMÂNTICA: Segurança em duas camadas (Autenticação + Autorização). 
 * Bernardo, essa é a marca de um desenvolvedor avançado: exigir que o usuário não só prove QUEM ele é ('auth'), 
 * mas também prove que tem PRIVILÉGIOS ('admin') para gerenciar Profissionais e Usuários.
 */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('profissionais', ProfissionaisController::class)->parameters(['profissionais' => 'profissional']);
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuarios']);
});