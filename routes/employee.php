<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Http\Middleware\RoleMiddleware;

Route::middleware(['auth', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
