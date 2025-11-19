<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/empregados', function () {
    return view('empregados');
})->name('empregados');

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
