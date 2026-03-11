<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AgendamentosController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('cadastro');
});

//Aqui Bernardo, é toda a parte de login e cadastro, essas rota estão fora do middleware de autenticação porque o usuário precisa acessar elas sem estar logado.
Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Aqui estão as rotas protegidas por autenticação, ou seja, o usuário precisa estar logado para acessar essas páginas.
Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClientesController::class)->parameters(['clientes' => 'cliente']);
    Route::resource('servicos', ServicosController::class)->parameters(['servicos' => 'servico']);
    Route::resource('agendamentos', AgendamentosController::class)->parameters(['agendamentos' => 'agendamento']);
});


//Aqui estão as rotas protegidas por autenticação e autorização, ou seja, o usuário precisa estar logado e ser um administrador para acessar essas páginas.
Route::middleware(['auth', 'admin'])->group(function () {

    
    Route::resource('profissionais', ProfissionaisController::class)->parameters(['profissionais' => 'profissional']);
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuarios']);


});



