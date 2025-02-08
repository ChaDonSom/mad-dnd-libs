<?php

use Illuminate\Support\Facades\Route;

// Define web routes for the application
Route::get('/', function () {
    return view('welcome');
});

// Additional routes can be defined here as the application grows.