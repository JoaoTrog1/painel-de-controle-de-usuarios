<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/painel-jmz/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/painel-jmz/app', [AppController::class, 'showApp']);

// Route::middleware('auth:sanctum')->get('/protected-message', function () {
//     return response()->json(['message' => 'Esta é uma rota protegida!']);
// });