<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RedirectorController;
use App\Http\Controllers\AuthController;

// Регистрация
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Авторизация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Выход
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/', function () { return view('welcome'); });

Route::get('/offers', [OfferController::class, 'index'])->middleware('auth');
Route::get('/offers/{id}', [OfferController::class, 'show'])->middleware('auth');
Route::get('/offers/create', [OfferController::class, 'create'])->middleware('auth');
Route::post('/offers', [OfferController::class, 'store'])->middleware('auth');

Route::get('/affiliate-links', [\App\Http\Controllers\WebmasterController::class, 'affiliateLinks']);
Route::get('/go/{token}', [RedirectorController::class, 'redirect']);
