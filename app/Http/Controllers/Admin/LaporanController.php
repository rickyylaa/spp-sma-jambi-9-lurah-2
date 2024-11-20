<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\PDF as PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ',request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }

        $pembayaran = Pembayaran::with(['siswa'])->whereBetween('created_at', [$start, $end])->where('status', 'diterima')->get();
        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.laporan.index', compact('pembayaran', 'notification'));
    }

    public function pdf($dateRange)
    {
        $date = explode('+', $dateRange);
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        $pembayaran = Pembayaran::with(['siswa', 'spp'])->whereBetween('created_at', [$start, $end])->where('status', 'diterima')->get();
        return view('aktor.admin.halaman.laporan.pdf', compact('pembayaran', 'date'));
    }
}
