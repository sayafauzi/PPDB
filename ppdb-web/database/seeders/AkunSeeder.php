<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Akun;
use App\Models\AkunSekolah;
use App\Models\Sekolah;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Super Admin
        Akun::updateOrCreate(
            ['id' => 'SU20241001000AB1C2', 'email' => 'superadmin@ppdb.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'tipe_akun' => 'SU', // SU = Super Admin
            ]
        );

        
    }
}
