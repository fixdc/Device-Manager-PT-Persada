<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserManagementController;
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

// Rute Publik untuk Scan QR Code Perangkat Berdasarkan Kode Device
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

        Route::get('/create-ticket', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/create-ticket', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/mydevice', fn () => view('users.device'))->name('devices.mine');
        Route::get('/myticket', [TicketController::class, 'index'])->name('tickets.mine');
        Route::get('/detail-ticket/{ticket}', [TicketController::class, 'show'])
            ->whereNumber('ticket')
            ->name('tickets.mine.show');
    });

    // --------------------------------------
    // ADMIN ROUTES
    // --------------------------------------
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function (): void {

        // Admin Dashboard & Laporan (Memanggil AdminController)
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/history', [AdminTicketController::class, 'history'])->name('history.index');

        // Ticket Management
        Route::get('/ticket', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/ticket/{ticket}', [AdminTicketController::class, 'show'])
            ->whereNumber('ticket')
            ->name('tickets.show');
        Route::patch('/ticket/{ticket}', [AdminTicketController::class, 'update'])
            ->whereNumber('ticket')
            ->name('tickets.update');
        // User Management (CRUD Lengkap API Resource)
        Route::apiResource('user', UserManagementController::class, [
            'names' => [
                'index' => 'users.index',
                'store' => 'users.store',
                'update' => 'users.update',
                'destroy' => 'users.destroy',
            ],
        ])->except(['show']);

        // Device & Location Management (CRUD Lengkap)
        Route::resource('device', DeviceController::class)->except(['show', 'create', 'edit']);
        Route::resource('location', LocationController::class)->except(['show', 'create', 'edit']);
        Route::resource('category', CategoryController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'categories.index',
                'store' => 'categories.store',
                'update' => 'categories.update',
                'destroy' => 'categories.destroy',
            ]);
    });
});
