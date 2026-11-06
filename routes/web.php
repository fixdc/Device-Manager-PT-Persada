<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});
Route::view('/kelola-user', 'kelola_user.kelola_user')->name('kelola.user');