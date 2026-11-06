<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::get('/tickets', function () {
    return view('tickets.index');
})->name('tickets.index');
