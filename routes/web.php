<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\LoginController;

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

Route::middleware(['auth'])->group(function(){
    Route::resource('clientes', ClientesController::class);
    Route::resource('servicos', ServicosController::class);
});

Route::middleware(['auth', 'admin'])->group(function(){
    Route::resource('profissionais', ProfissionaisController::class);
});



Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
