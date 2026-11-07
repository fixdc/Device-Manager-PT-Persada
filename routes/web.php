<?php

use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/device', function () {
    return view('device_details');
});

// AUTH USER

// ADMIN
Route::get('/admin/device', function () {
    return view('admins.device');
});
Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
});
