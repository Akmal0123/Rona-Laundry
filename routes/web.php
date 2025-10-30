<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('test1');
})->name('test1');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    return Inertia::render('test');
})->name('test');

Route::get('/landing', function () {
    return Inertia::render('LandingPage');
});

Route::get('/reservasi', function () {
    return Inertia::render('Reservasi');
});

Route::get('/test1', function () {
    return Inertia::render('test1');
});

Route::get('/masuk', function () {
    return Inertia::render('Register');
});

Route::get('/loh', function () {
    return Inertia::render('Login');
});

Route::get('/order', function () {
    return Inertia::render('Order');
});

Route::get('/admin-dashboard', function () {
    return Inertia::render('AdminDashboard');
});

Route::get('/user-profile', function () {
    return Inertia::render('Profile');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
