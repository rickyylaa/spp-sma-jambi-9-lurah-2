<?php

namespace Database\Seeders;

use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekening::create([
            'nama_bank' => 'bca',
            'pemilik_akun' => 'SMKS JAMBI IX LURAH 2',
            'rekening_akun' => '1234567890',
            'foto' => 'bca.png'
        ]);

        Rekening::create([
            'nama_bank' => 'bri',
            'pemilik_akun' => 'SMKS JAMBI IX LURAH 2',
            'rekening_akun' => '1234567890',
            'foto' => 'bri.png'
        ]);

        Rekening::create([
            'nama_bank' => 'bni',
            'pemilik_akun' => 'SMKS JAMBI IX LURAH 2',
            'rekening_akun' => '1234567890',
            'foto' => 'bni.png'
        ]);

        Rekening::create([
            'nama_bank' => 'mandiri',
            'pemilik_akun' => 'SMKS JAMBI IX LURAH 2',
            'rekening_akun' => '1234567890',
            'foto' => 'mandiri.png'
        ]);

        Rekening::create([
            'nama_bank' => 'ovo',
            'pemilik_akun' => 'SMKS JAMBI IX LURAH 2',
            'rekening_akun' => '1234567890',
            'foto' => 'ovo.png'
        ]);
    }
}
