<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Http\Middleware\RoleMiddleware;

Route::middleware(['auth', 'role:admin'])->prefix('employee')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('admin.Dashboard');
    })->name('dashboard');
});
