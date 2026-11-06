<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::view('/detail-tiket-admin', 'detail_tiket_admin.index');