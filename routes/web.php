<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PicagensController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckRoles;
use Illuminate\Support\Facades\Route;


//LOGIN

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/submit', [AuthController::class, 'submit'])->name('submit');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::middleware([CheckIsLogged::class])->group(function () {

    Route::middleware([CheckRoles::class . ':employee'])->group(function () {
        Route::get('/registo', function () {
            return view('resgistar-picagem');
        })->name('registo');
    });

    Route::middleware([CheckRoles::class . ':admin|manager'])->group(function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

        Route::get('/picagens', [PicagensController::class, 'index'])->name('picagens');
        Route::get('/picagens/data', [PicagensController::class, 'data'])->name('picagens.data');

        Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');
        
        Route::get('/empregados', [UserController::class, 'index'])->name('empregados');
        Route::post('/empregados', [UserController::class, 'create'])->name('empregados');
        Route::put('/empregados/{id}', [UserController::class, 'update'])->name('empregados.update');
        Route::delete('/empregados/{id}', [UserController::class, 'destroy'])->name('empregados.destroy');
    });
});
