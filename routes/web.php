<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UjianController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AuthController;

// ===============================
// Auth Routes
// ===============================
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// Admin Routes
// ===============================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::get('/list', [AdminController::class, 'list'])->name('list');
    Route::get('/score', [AdminController::class, 'score'])->name('score');

    //tambahan dari list
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
});




// ===============================
// User Routes
// ===============================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('ujian');
    Route::get('/detail/{ujian}', [UserController::class, 'show'])->name('detail');
    Route::post('/mulai/{ujian}', [UserController::class, 'start'])->name('mulai');
    Route::get('/ujian/{ujian}', [UserController::class, 'detail'])->name('ujian.detail');
    Route::post('/ujian/{ujian}/submit', [UserController::class, 'submit'])->name('submit');
    Route::get('/ujian/{ujian}/selesai', [UserController::class, 'finish'])->name('ujian.selesai');
});

