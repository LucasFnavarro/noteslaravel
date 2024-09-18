<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use Illuminate\Support\Facades\Route;

// rotas livre para usuários que não estão na session!
Route::get('/login', [AuthController::class, 'index']);
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);

// Bloqueia o acesso a determinadas rotas caso o usuário não esteja logado
Route::middleware([CheckIsLogged::class])->group(function(){
    Route::get('/', [MainController::class, 'index']);
    Route::get('/newNote', [MainController::class, 'newNote']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
