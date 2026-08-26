<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => true,
        'message' => 'Welcome to Basary Souq API',
        'version' => '1.0.0'
    ]);
});