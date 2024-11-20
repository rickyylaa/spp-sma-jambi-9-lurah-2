<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function wali()
    {
        return $this->belongsTo(User::class)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'wali');
            });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
