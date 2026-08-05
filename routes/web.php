<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ControladorController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\KeyLoanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas / Autenticação
|--------------------------------------------------------------------------
*/
// Exibição da tela de login na raiz e em /login
// Rotas Públicas de Autenticação
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
// A rota GET /register agora exibe a mesma tela unificada
Route::get('/register', [LoginController::class, 'showLoginForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');


/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Apenas Usuários Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Painel Principal de Empréstimos e Devoluções
    Route::get('/dashboard', [KeyLoanController::class, 'index'])->name('loans.index');
    Route::post('/retirar', [KeyLoanController::class, 'checkout'])->name('loans.checkout');
    Route::patch('/devolver/{id}', [KeyLoanController::class, 'checkin'])->name('loans.checkin');

    // CRUD de Chaves
    Route::get('/chaves', [KeyController::class, 'index'])->name('keys.index');
    Route::post('/chaves', [KeyController::class, 'store'])->name('keys.store');
    Route::delete('/chaves/{key}', [KeyController::class, 'destroy'])->name('keys.destroy');

    // Gerenciamento de Controladores
    Route::get('/controladores', [ControladorController::class, 'index'])->name('controladores.index');
    Route::post('/controladores', [ControladorController::class, 'store'])->name('controladores.store');
    Route::delete('/controladores/{id}', [ControladorController::class, 'destroy'])->name('controladores.destroy');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Apenas Controladores Logados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:controlador')->group(function () {
    // Painel Principal
    Route::get('/dashboard', [KeyLoanController::class, 'index'])->name('loans.index');
    Route::post('/retirar', [KeyLoanController::class, 'checkout'])->name('loans.checkout');
    Route::patch('/devolver/{id}', [KeyLoanController::class, 'checkin'])->name('loans.checkin');
    // Histórico Geral de Empréstimos e Devoluções
    Route::get('/historico', [KeyLoanController::class, 'history'])->name('loans.history');
    // CRUD de Chaves
    Route::get('/chaves', [KeyController::class, 'index'])->name('keys.index');
    Route::post('/chaves', [KeyController::class, 'store'])->name('keys.store');
    Route::delete('/chaves/{key}', [KeyController::class, 'destroy'])->name('keys.destroy');

    // CRUD de Controladores
    Route::get('/controladores', [ControladorController::class, 'index'])->name('controladores.index');
    Route::post('/controladores', [ControladorController::class, 'store'])->name('controladores.store');
    Route::delete('/controladores/{id}', [ControladorController::class, 'destroy'])->name('controladores.destroy');



    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
