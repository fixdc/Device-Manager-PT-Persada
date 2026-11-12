<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admins.dashboard', [
            'adminName' => Auth::user()?->nama ?? 'Admin',
            'totalPerangkat' => Device::count(),
            'totalUser' => User::count(),
            'totalTiket' => Ticket::count(),
            'tiketPending' => Ticket::where('status', 'pending')->count(),
            'tiketProses' => Ticket::whereIn('status', ['proses', 'diproses'])->count(),
            'kondisiBaik' => Device::where('status', 'aktif')->count(),
            'kondisiPerbaikan' => Device::where('status', 'perbaikan')->count(),
            'kondisiRusak' => Device::where('status', 'rusak')->count(),
            'tiketBaru' => Ticket::with(['device', 'user'])->latest()->take(5)->get(),
            'riwayat' => Ticket::with(['device', 'technician'])->latest()->take(5)->get(),
        ]);
    }
}