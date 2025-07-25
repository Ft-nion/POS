<?php

use App\Http\Controllers\CashRegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController; // Agrega el controlador de compras
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('purchases', PurchaseController::class); // Agrega la ruta resource de compras
    Route::resource('cash_registers', CashRegisterController::class); // Asegúrate de importar el controlador de caja
    Route::resource('users', UserController::class)->middleware('auth');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/export', [ProductController::class, 'export'])->name('export');
    Route::post('/import', [ProductController::class, 'import'])->name('import');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
