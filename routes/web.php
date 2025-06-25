<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RedirectorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { return view('welcome'); });

// Регистрация
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Авторизация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Выход
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Офферы
Route::get('/offers', [OfferController::class, 'index'])->middleware('auth');
Route::get('/offers/create', [OfferController::class, 'create'])->middleware('auth');
Route::post('/offers', [OfferController::class, 'store'])->middleware('auth');
Route::get('/offers/{id}', [OfferController::class, 'show'])->middleware('auth');

// Веб-мастер
Route::get('/webmaster', [\App\Http\Controllers\WebmasterController::class, 'index'])->middleware('auth');
Route::get('/webmaster/links', [\App\Http\Controllers\WebmasterController::class, 'affiliateLinks'])->middleware('auth');
Route::post('/webmaster/subscribe/{offer_id}', [\App\Http\Controllers\WebmasterController::class, 'subscribe'])->middleware('auth');

// Admin
// Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'admin']);
Route::get('/admin', [AdminController::class, 'dashboard'])->middleware('auth');
Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->middleware('auth');
// Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->middleware(['auth', 'admin']);


Route::get('/affiliate-links', [\App\Http\Controllers\WebmasterController::class, 'affiliateLinks']);
Route::get('/go/{token}', [RedirectorController::class, 'redirect']);
