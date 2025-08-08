<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Http\Controllers\TransactionHistoryController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::resource('suppliers', SupplierController::class)
//     ->middleware(['auth', 'role:admin'])
//     ->names('suppliers');
// Route::resource('customers', CustomerController::class)
//     ->middleware(['auth', 'role:admin'])
//     ->names('customers');
// Route::resource('incoming-transactions', IncomingTransactionController::class)
//     ->middleware(['auth'])
//     ->names('incoming-transactions');
// Route::resource('outgoing-transactions', OutgoingTransactionController::class)
//     ->middleware(['auth'])
//     ->names('outgoing-transactions');
Route::middleware(['role:admin'])->group(function () {
        Route::resource('suppliers', SupplierController::class)->names('suppliers');
        Route::resource('customers', CustomerController::class)->names('customers');
    });

Route::middleware(['auth', 'permission:create-transactions'])->group(function () {
        Route::resource('incoming-transactions', IncomingTransactionController::class)->names('incoming-transactions');
        Route::resource('outgoing-transactions', OutgoingTransactionController::class)->names('outgoing-transactions');
        Route::get('transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction-history');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
