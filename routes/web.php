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
    return view('device-details');
});

// AUTH USER
Route::get('/dashboard', function () { //
    return view('users.dashboard');
});
Route::get('/create-ticket', function () {
    return view('users.create-ticket');
});
Route::get('/mydevice', function () {
    return view('users.device');
});
Route::get('/myticket', function () {
    return view('users.ticket');
});
Route::get('/detail-ticket', function () { //
    return view('users.ticket-detail');
});



// ADMIN
Route::get('/admin/ticket/detail', function () {
    return view('admins.detail-ticket');
});

Route::get('/admin/ticket', function () {
    return view('admins.ticket');
});

Route::get('/admin/device', function () {
    return view('admins.device');
});

Route::get('/admin/dashboard', function () {
    return view('admins.dashboard');
});

Route::get('/admin/user', function () {
    return view('admins.user');
});

Route::get('/admin/history', function () {
    return view('admins.history');
});