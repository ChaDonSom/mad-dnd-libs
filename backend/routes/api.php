<?php

use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Public authentication routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['as' => 'api.'], function () {
    // Public routes
    // Orion::resource('public-content', 'PublicContentController');

    // Player routes with middleware
    Route::middleware(['auth:sanctum', 'role:player'])->group(function () {
        Orion::resource('games', GameController::class)->only(['index', 'show']);
        Route::post('/games/join/{code}', [GameController::class, 'join']);
        Route::post('/games/{game}/vote', [GameController::class, 'vote']);
    });

    // Host routes with middleware
    Route::middleware(['auth:sanctum', 'role:host'])->group(function () {
        Orion::resource('games', GameController::class)->except(['index', 'show']);
        Route::post('/games/{game}/start', [GameController::class, 'start']);
        Route::post('/games/{game}/transfer-host', [GameController::class, 'transferHost']);
    });

    // Admin routes with middleware
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Orion::resource('roles', RoleController::class);
        Orion::resource('permissions', PermissionController::class);
        Orion::resource('users', UserController::class);
    });
});
