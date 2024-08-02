<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [AuthController::class, 'redirectToDashboard'])->name('dashboard');

/* --- Authentication --- */
Route::middleware(['redirect'])->prefix('auth')->group(function () {
    Route::get('login',     [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login',    [AuthController::class, 'login'        ])->name('auth.login.post');
    Route::get('logout',    [AuthController::class, 'logout'       ])->name('auth.logout');

    Route::get('register',  [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/employee.php';
