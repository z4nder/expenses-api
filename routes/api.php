<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum')->name('me');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::prefix('expenses')->middleware('auth:sanctum')->name('expenses.')->group(function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('index');
    Route::post('/', [ExpenseController::class, 'store'])->name('store');
    Route::get('/{expense}', [ExpenseController::class, 'show'])->name('show');
    Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');
    Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
});

Route::prefix('status')->middleware('auth:sanctum')->name('status.')->group(function () {
    Route::get('/expense', [ExpenseController::class, 'expenseStatus'])->name('expense');
});
