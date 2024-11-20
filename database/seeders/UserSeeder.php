<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        User::create([
            'username' => 'admin',
            'nama' => 'Admin',
            'password' => Hash::make(1),
            'telepon' => '+6281234567890',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jambi',
            'foto' => 'avatar.png'
        ])->assignRole('admin');

        User::create([
            'username' => 'operator',
            'nama' => 'Operator',
            'password' => Hash::make(1),
            'telepon' => '+6281234567890',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jambi',
            'foto' => 'avatar.png'
        ])->assignRole('operator');

        User::create([
            'username' => 'wali',
            'nama' => 'Wali',
            'password' => Hash::make(1),
            'telepon' => '+6281234567890',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jambi',
            'foto' => 'avatar.png'
        ])->assignRole('wali');

        for ($i = 1; $i <= 50; $i++) {
            $nama = $faker->firstName;
            $username = Str::slug($nama, '') . rand(0, 999);

            User::create([
                'username' => $username,
                'nama' => $faker->name,
                'password' => Hash::make('1'),
                'telepon' => $faker->numerify('+628##########'),
                'jenis_kelamin' => $faker->randomElement(['laki-laki', 'perempuan']),
                'alamat' => $faker->address,
                'foto' => 'avatar.png',
            ])->assignRole('wali');
        }
    }
}
