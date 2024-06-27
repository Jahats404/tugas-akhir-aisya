<?php

namespace Database\Seeders;

use App\Models\PetugasArpus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '123123',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role_id' => 1,
            'remember_token' => Str::random(60),
        ]);
        PetugasArpus::create([
            'nik' => '123123',
            'name' => 'admin',
            'tanggal_lahir' => '2023-06-30',
            'kk' => '123123',
            'no_hp' => '123123',
            'kecamatan' => 'kesugihan',
            'desa' => 'kalisabuk',
        ]);
    }
}
