<?php

/*
 * SINTAXE: use ...
 * SEMÂNTICA: Muito bem, Bernardo! Aqui você está importando as classes de todos os seus Controllers 
 * para que este arquivo de rotas saiba exatamente onde procurar a lógica de cada URL.
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AgendamentosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\GoogleController; 

// NOVO: Importação do controlador responsável pela segurança das contas.
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota principal: assim que o sistema abre (localhost:8000), redireciona direto para o cadastro
Schedule::command('app:update-expired-appointments')->everyMinute();
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/agendamentos/json', [AgendamentosController::class, 'json'])
     ->name('agendamentos.json');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Aqui, Bernardo, é toda a parte de login e cadastro.
Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


//  ADICIONADO (Google)
Route::get('/google', [GoogleController::class, 'redirect']);
Route::get('/google/callback', [GoogleController::class, 'callback']);


// Aqui estão as rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    
    Route::resource('clientes', ClientesController::class)->parameters(['clientes' => 'cliente']);
    Route::resource('servicos', ServicosController::class)->parameters(['servicos' => 'servico']);
    Route::resource('agendamentos', AgendamentosController::class)->parameters(['agendamentos' => 'agendamento']);
    
});


// Rotas com admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('profissionais', ProfissionaisController::class)->parameters(['profissionais' => 'profissional']);
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuarios']);
});

// ROTAS DE RECUPERAÇÃO DE SENHA
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Exportar agendamentos
Route::get('/exportar-agendamentos', [AgendamentosController::class, 'exportarExcel'])->name('agendamentos.exportar');

// Financeiro
Route::get('/financeiro', [CobrancaController::class, 'index'])->name('cobrancas.index');