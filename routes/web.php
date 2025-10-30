<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User as AppUserModel;
use App\Models\Pesanan as AppPesananModel;
use App\Models\LayananLaundry as AppLayananModel;
use App\Http\Controllers\Auth\AuthenticatedSessionController as WebLoginController;
use App\Http\Controllers\Auth\RegisteredUserController as WebRegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('LandingPage');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('Dashboard');

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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/order', function () {
    return Inertia::render('Order');
});

Route::get('/admin/dashboard', function () {
    return Inertia::render('admin/AdminDashboard');
})->middleware(['auth', 'verified']);
Route::get('/admin/users-page', function () {
    return Inertia::render('admin/AdminUsers');
})->middleware(['auth', 'verified']);
Route::get('/admin/products-page', function () {
    return Inertia::render('admin/AdminProducts');
})->middleware(['auth', 'verified']);
Route::get('/admin/orders-page', function () {
    return Inertia::render('admin/AdminOrders');
})->middleware(['auth', 'verified']);
Route::get('/admin/payments-page', function () {
    return Inertia::render('admin/AdminPaymentVerification');
})->middleware(['auth', 'verified']);
Route::get('/admin/login', function () {
    return Inertia::render('auth/Login', [
        'isAdminLogin' => true
    ]);
})->name('admin.login');

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

Route::middleware(['auth', 'verified'])->get('/admin/dashboard-data', function () {
    return response()->json([
        'stats' => [
            'totalProducts' => AppLayananModel::count(),
            'totalUsers' => AppUserModel::count(),
            'totalOrders' => AppPesananModel::count(),
            'pendingVerification' => AppPesananModel::where('status_order', 'pending_verification')->count(),
        ],
        'recentOrders' => AppPesananModel::with('user')->orderByDesc('created_at')->limit(5)->get(),
        'recentUsers' => AppUserModel::orderByDesc('created_at')->limit(5)->get(),
    ]);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
