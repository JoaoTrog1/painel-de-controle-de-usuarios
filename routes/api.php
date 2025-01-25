<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ViewDataController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/painel-jmz/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/painel-jmz/app', [AppController::class, 'showApp']);

Route::middleware('auth:sanctum')->get('/painel-jmz/functions', [ViewDataController::class, '']);


Route::middleware('auth:sanctum')->get('/painel-jmz/functions', [ViewDataController::class, 'getAllFunctions']);
// Route::middleware('auth:sanctum')->get('/protected-message', function () {
//     return response()->json(['message' => 'Esta é uma rota protegida!']);
// });