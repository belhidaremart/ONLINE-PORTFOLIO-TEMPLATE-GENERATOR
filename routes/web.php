<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('portfolios', PortfolioController::class);

Route::get('/portfolios/{portfolio}/template', [PortfolioController::class, 'template'])
    ->name('portfolios.template');
Route::put('/portfolios/{portfolio}/template', [PortfolioController::class, 'updateTemplate'])
    ->name('portfolios.template.update');