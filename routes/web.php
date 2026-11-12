<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return $request->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/device', fn () => view('device-details'))->name('device.public');

Route::middleware(['auth', 'auth.session'])->group(function (): void {
    Route::middleware('role:user')->group(function (): void {
        Route::get('/dashboard', fn (Request $request) => view('users.dashboard', [
            'userName' => $request->user()->nama,
        ]))->name('dashboard');

        Route::get('/create-ticket', fn () => view('users.create-ticket'))->name('tickets.create');
        Route::get('/mydevice', fn () => view('users.device'))->name('devices.mine');
        Route::get('/myticket', fn () => view('users.ticket'))->name('tickets.mine');
        Route::get('/detail-ticket', fn () => view('users.ticket-detail'))->name('tickets.mine.show');
    });

    Route::patch('/account-settings/profile', [AccountSettingsController::class, 'updateProfile'])
        ->name('account-settings.profile.update');
    Route::patch('/account-settings/notifications', [AccountSettingsController::class, 'updateNotifications'])
        ->name('account-settings.notifications.update');
    Route::put('/account-settings/password', [AccountSettingsController::class, 'updatePassword'])
        ->name('account-settings.password.update');
    Route::get('/account-settings/sessions', [AccountSettingsController::class, 'sessions'])
        ->name('account-settings.sessions.index');
    Route::post('/account-settings/sessions/logout-others', [AccountSettingsController::class, 'logoutOtherDevices'])
        ->name('account-settings.sessions.destroy-others');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function (): void {
            Route::get('/dashboard', fn () => view('admins.dashboard'))->name('dashboard');
            Route::get('/ticket/detail', fn () => view('admins.detail-ticket'))->name('tickets.show');
            Route::get('/ticket', fn () => view('admins.ticket'))->name('tickets.index');
            Route::get('/device', fn () => view('admins.device'))->name('devices.index');
            Route::get('/history', fn () => view('admins.history'))->name('history.index');

            Route::get('/user', [UserManagementController::class, 'index'])->name('users.index');
            Route::post('/user', [UserManagementController::class, 'store'])->name('users.store');
            Route::put('/user/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/user/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        });
});
