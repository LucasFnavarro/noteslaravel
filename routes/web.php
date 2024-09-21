<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// caso o usuário esteja logado e tente voltar para a página de login
$router->middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// Acesso apenas para usuários logado na session.
$router->middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newnotesubmit');

    // Editar notas
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
