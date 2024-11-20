<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nisn',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'foto',
        'kelas_id',
        'angkatan',
        'wali_id'
    ];

    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir->format('d F Y');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }

    public function pembayaranDetail()
    {
        return $this->hasMany(PembayaranDetail::class, 'siswa_id');
    }

    public function spp()
    {
        return $this->hasOne(Spp::class);
    }
}
