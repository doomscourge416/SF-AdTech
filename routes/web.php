<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RedirectorController;

Route::get('/', function () { return view('welcome'); });
Route::get('/offers', [OfferController::class, 'index']);
Route::get('/affiliate-links', [\App\Http\Controllers\WebmasterController::class, 'affiliateLinks']);
Route::get('/go/{token}', [RedirectorController::class, 'redirect']);
