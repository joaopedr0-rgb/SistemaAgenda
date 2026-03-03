<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;

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
    return redirect()->route('profissionais.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClientesController::class)->parameters(['clientes' => 'cliente']);
    Route::resource('servicos', ServicosController::class)->parameters(['servicos'=> 'servico']);
});

//Route::middleware(['auth', 'admin'])->group(function(){
//Route::resource('profissionais', ProfissionaisController::class);
//});
Route::middleware(['auth'])->group(function () {

    // Procure a linha do Resource e adicione o array parameters
    Route::resource('profissionais', ProfissionaisController::class)->parameters([
        'profissionais' => 'profissional'


    ]);
});

Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store']);


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


