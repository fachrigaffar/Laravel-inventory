<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('suppliers', SupplierController::class);
Route::resource('customers', CustomerController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
// require __DIR__.'/admin.php';
// require __DIR__.'/employee.php';
