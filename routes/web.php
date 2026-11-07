<?php

use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});

Route::view('/detail-tiket-admin', 'detail_tiket_admin.index');

// AUTH USER

// ADMIN
Route::get('/admin/ticket', function () {
    return view('admins.ticket');
})->name('tickets.index');

Route::get('/admin/device', function () {
    return view('admins.device');
});
Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
});
Route::get('/admin/user', function () {
    return view('admins.user');
});
