<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});
Route::get('/admin/device', function () {
    return view('admins.device');
});
