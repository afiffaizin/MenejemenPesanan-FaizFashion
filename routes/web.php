<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout Route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrderController::class, 'index'])->name('orders.index');

    // orders
    Route::get('/order', [OrderController::class, 'getOrders'])->name('orders.getOrders');
    Route::get('/customers/{customer}/sizes', [OrderController::class, 'getSizes'])->name('orders.getSizes');
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/order/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

    // customers
    Route::get('/customer', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customer/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customers.update');
});
