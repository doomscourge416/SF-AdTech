<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RedirectorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WebmasterController;
use App\Http\Controllers\DashboardController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Авторизация
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// По авторизации
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/offers', [OfferController::class, 'index']);
    Route::get('/offers/create', [OfferController::class, 'create']);
    Route::post('/offers', [OfferController::class, 'store']);
    Route::get('/offers/{offer}', [OfferController::class, 'show']);
});

// Редирект
Route::get('/go/{token}', [RedirectorController::class, 'redirect']);

// Веб-мастер
Route::middleware(['auth'])->prefix('webmaster')->group(function () {
    Route::get('/webmaster/links', [AffiliateLinkController::class, 'index'])->name('webmaster.links');
    Route::get('/links', [WebmasterController::class, 'index']);
    Route::post('/subscribe/{offer}', [WebmasterController::class, 'subscribe']);
});

// Админка
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/block/{id}', [AdminController::class, 'block'])->name('admin.block');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
});
