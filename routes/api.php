<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('/users')->controller(AuthController::class)->group(function () {
    Route::post('/registration', 'registration');
    Route::post('/login', 'createToken');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/episodes/{episode}/summary', [EpisodeController::class, 'summary']);
});
