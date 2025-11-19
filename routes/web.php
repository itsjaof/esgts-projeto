<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/empregados', function () {
    return view('empregados');
})->name('empregados');
