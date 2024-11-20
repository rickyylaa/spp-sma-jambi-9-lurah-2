<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'angkatan',
        'periode',
        'nominal'
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }

    public static function getNominalByPeriode($periode)
    {
        return self::where('periode', $periode)->first();
    }
}
