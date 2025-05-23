<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ViewDataController;

Route::get('/', function () {
    return view('welcome');
});




Route::prefix('painel')->name('painel.')->group(function () {
    Route::post('{admin}/functions/app-name', [ViewDataController::class, 'updateAppName'])->name('functions.appname');
    Route::get('{admin}/functions', [ViewDataController::class, 'index'])->name('functions.index');
    Route::get('{admin}/functions/edit/{id}', [ViewDataController::class, 'edit'])->name('functions.edit');
    Route::delete('{admin}/functions/delete/{id}', [ViewDataController::class, 'delete'])->name('functions.delete');
    Route::post('{admin}/functions/store', [ViewDataController::class, 'store'])->name('functions.store');
});

Route::get('/painel', [PainelController::class, 'painel'])->name('painel');
Route::post('/painel/login', [PainelController::class, 'login'])->name('painel.login');
Route::get('/painel/logout', [PainelController::class, 'logout'])->name('painel.logout');

Route::get('/painel/{admin}/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/painel/{admin}/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/painel/{admin}/users/index', [UserController::class, 'index'])->name('users.index');
Route::get('/painel/{admin}/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::put('/painel/{admin}/users/{user}/update', [UserController::class, 'update'])->name('users.update');

Route::get('/painel/{admin}/users/{user}/reset', [UserController::class, 'reset'])->name('users.reset');

Route::get('/painel/app/create', [AppController::class, 'showCreateForm'])->name('app.create');
Route::post('/painel/app', [AppController::class, 'store'])->name('app.store');
//Route::get('/painel/app/{id}/edit', [AppController::class, 'showEditForm'])->name('app.edit');
//Route::put('/painel/app/{id}', [AppController::class, 'update'])->name('app.update');

Route::get('/painel/{admin}/app/{id}/edit', [AppController::class, 'showEditForm'])->name('app.edit');
Route::put('/painel/{admin}/app/{id}', [AppController::class, 'update'])->name('app.update');
Route::delete('/painel/{admin}/user/{id}', [UserController::class, 'destroy'])->name('users.destroy');
