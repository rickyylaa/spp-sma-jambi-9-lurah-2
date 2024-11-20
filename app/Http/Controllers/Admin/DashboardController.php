<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;
        $siswa = Siswa::get();

        $wali = User::whereHas('roles', function ($query) {
            $query->where('name', 'wali');
        })->get();

        $riwayat = Pembayaran::with(['siswa', 'spp'])
            ->whereYear('created_at', $currentYear)
            ->get();

        $pemasukan = Pembayaran::whereYear('created_at', $currentYear)
            ->where('status', 'diterima')
            ->sum('jumlah');

        $aktivity = Pembayaran::with(['siswa', 'spp'])
            ->whereYear('created_at', $currentYear)
            ->latest()
            ->get();

        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.dashboard.index', compact('siswa', 'wali', 'riwayat', 'pemasukan', 'aktivity', 'notification'));
    }
}
