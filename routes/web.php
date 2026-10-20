<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Only visitors who are NOT logged in can open these pages.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Only logged-in users can use the portfolio pages.
Route::middleware('auth')->group(function () {
    Route::resource('portfolios', PortfolioController::class);

    Route::get('/portfolios/{portfolio}/template', [PortfolioController::class, 'template'])
        ->name('portfolios.template');
    Route::put('/portfolios/{portfolio}/template', [PortfolioController::class, 'updateTemplate'])
        ->name('portfolios.template.update');
});