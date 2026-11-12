<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// HOME & PUBLIC ROUTES
// ==========================================
Route::get('/', function (Request $request) {
    if ($request->user()) {
        return $request->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/device/{kode_device}', [DeviceController::class, 'showPublic'])->name('device.public');

// ==========================================
// GUEST ROUTES (AUTHENTICATION)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

// ==========================================
// AUTHENTICATED ROUTES
// ==========================================
Route::middleware(['auth', 'auth.session'])->group(function (): void {
    
    // Global Logout
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // --------------------------------------
    // ACCOUNT SETTINGS
    // --------------------------------------
    Route::prefix('account-settings')->name('account-settings.')->group(function () {
        Route::patch('/profile', [AccountSettingsController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/notifications', [AccountSettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::put('/password', [AccountSettingsController::class, 'updatePassword'])->name('password.update');
        Route::get('/sessions', [AccountSettingsController::class, 'sessions'])->name('sessions.index');
        Route::post('/sessions/logout-others', [AccountSettingsController::class, 'logoutOtherDevices'])->name('sessions.destroy-others');
    });

    // --------------------------------------
    // USER ROUTES (STAFF / KARYAWAN)
    // --------------------------------------
    Route::middleware('role:user')->group(function (): void {
        Route::get('/dashboard', fn (Request $request) => view('users.dashboard', [
            'userName' => $request->user()->nama,
        ]))->name('dashboard');

        Route::get('/create-ticket', fn () => view('users.create-ticket'))->name('tickets.create');
        Route::get('/mydevice', fn () => view('users.device'))->name('devices.mine');
        Route::get('/myticket', fn () => view('users.ticket'))->name('tickets.mine');
        Route::get('/detail-ticket', fn () => view('users.ticket-detail'))->name('tickets.mine.show');
    });

    // --------------------------------------
    // ADMIN ROUTES
    // --------------------------------------
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function (): void {
        
        // Admin Dashboard & Laporan
        Route::get('/dashboard', fn () => view('admins.dashboard'))->name('dashboard');
        Route::get('/history', fn () => view('admins.history'))->name('history.index');
        
        // Ticket Management (Sementara pakai closure, nanti bisa diubah ke resource controller)
        Route::get('/ticket', fn () => view('admins.ticket'))->name('tickets.index');
        Route::get('/ticket/detail', fn () => view('admins.detail-ticket'))->name('tickets.show');

        // User Management (CRUD Lengkap API Resource)
        Route::apiResource('user', UserManagementController::class)->except(['show']);

        // Device & Location Management (CRUD Lengkap)
        // Ini akan otomatis membuat route: index, create, store, edit, update, destroy
        Route::resource('device', DeviceController::class)->except(['show', 'create', 'edit']);
        Route::resource('location', LocationController::class)->except(['show', 'create', 'edit']);
    });
});