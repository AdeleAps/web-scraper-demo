<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/posts/{post}', [DashboardController::class, 'delete'])->name('delete');
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    } else {
        return Inertia::render('Auth/Login');
    }
});
