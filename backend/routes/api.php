<?php

use App\Http\Controllers\API\ExampleGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/test', [TestController::class, 'index']);

// Example routes - to be replaced with actual game routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/examples/templates', [ExampleGameController::class, 'getTemplates']);
        Route::get('/examples/story/{id}', [ExampleGameController::class, 'getStory']);
    });
});
