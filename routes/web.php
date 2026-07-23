<?php

use App\Http\Controllers\KeyController;
use App\Http\Controllers\KeyLoanController;
use Illuminate\Support\Facades\Route;

// Painel de Empréstimos e Devoluções
Route::get('/', [KeyLoanController::class, 'index'])->name('loans.index');
Route::post('/retirar', [KeyLoanController::class, 'checkout'])->name('loans.checkout');
Route::patch('/devolver/{id}', [KeyLoanController::class, 'checkin'])->name('loans.checkin');

// CRUD de Chaves
Route::get('/chaves', [KeyController::class, 'index'])->name('keys.index');
Route::post('/chaves', [KeyController::class, 'store'])->name('keys.store');
Route::delete('/chaves/{key}', [KeyController::class, 'destroy'])->name('keys.destroy');
