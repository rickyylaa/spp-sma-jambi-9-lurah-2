<?php

namespace Database\Seeders;

use App\Models\Spp;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spp::create([
            'angkatan' => '2022',
            'periode' => '2022/2023',
            'nominal' => 250000,
        ]);

        Spp::create([
            'angkatan' => '2023',
            'periode' => '2023/2024',
            'nominal' => 260000
        ]);

        Spp::create([
            'angkatan' => '2024',
            'periode' => '2024/2025',
            'nominal' => 270000
        ]);
    }
}
