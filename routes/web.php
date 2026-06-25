<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('coas', CoaController::class);
Route::resource('transactions', TransactionController::class);
Route::get('/profit-loss', [ProfitLossController::class, 'index'])
    ->name('profit-loss.index');
Route::get('/profit-loss/export',[ProfitLossController::class, 'export'])
    ->name('profit-loss.export');