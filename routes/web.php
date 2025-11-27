<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;


//LOGIN

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/submit', [AuthController::class, 'submit'])->name('submit');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/empregados', function () {
        return view('empregados');
    })->name('empregados');

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/picagens', function () {
        return view('picagens');
    })->name('picagens');

    Route::get('/registo', function () {
        return view('resgistar-picagem');
    })->name('registo');
});
