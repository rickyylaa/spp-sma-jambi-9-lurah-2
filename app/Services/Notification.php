<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Notification
{
    public static function getNotifications()
    {
        return DB::table('notifications')
            ->join('pembayarans', 'notifications.pembayaran_id', '=', 'pembayarans.id')
            ->join('siswas', 'notifications.siswa_id', '=', 'siswas.id')
            ->join('spps', 'notifications.spp_id', '=', 'spps.id')
            ->join('users', 'notifications.wali_id', '=', 'users.id')
            ->where('notifications.is_read', 0)
            ->select(
                'notifications.id as notification_id',
                'users.nama as nama_wali',
                'users.foto as foto_wali',
                'spps.periode as periode',
                'spps.nominal as nominal',
                'pembayarans.invoice as invoice',
                'pembayarans.metode_pembayaran as metode_pembayaran',
                'pembayarans.untuk_bulan as untuk_bulan',
                'pembayarans.jumlah as jumlah',
                'pembayarans.created_at as created_at'
            )
            ->orderBy('notifications.created_at', 'DESC')
            ->get();
    }
}
