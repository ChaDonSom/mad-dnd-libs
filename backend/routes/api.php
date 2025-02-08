<?php

use App\Http\Controllers\API\ExampleGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;

Route::get('/test', [TestController::class, 'index']);

// Example routes - to be replaced with actual game routes
Route::prefix('v1')->group(function () {
    Route::get('/examples/templates', [ExampleGameController::class, 'getTemplates']);
    Route::get('/examples/story/{id}', [ExampleGameController::class, 'getStory']);
});
