<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Akun;

class AkunUserSeeder extends Seeder
{
    public function run(): void
    {
        // Fungsi helper untuk generate ID custom
        $generateCustomId = function ($prefix = 'U') {
            $datePart = now()->format('Ymd');
            $randPart = strtoupper(Str::random(6));
            return "{$prefix}{$datePart}{$randPart}";
        };

        // Contoh akun orang tua (U)
        $akunOrtu = [
            [
                'id' => $generateCustomId('U'),
                'email' => 'parent1@ppdb.test',
                'password' => Hash::make('27052010'), // default dari tanggal lahir
                'tipe_akun' => 'U',
                'no_telp' => '081234567890',
                'name' => 'Budi Santoso',
                'tanggal_lahir' => '1980-05-27',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Mawar No. 12, Bandung',
                'kelurahan' => 'Sukasari',
                'kecamatan' => 'Cidadap',
                'id_sekolah' => null,
            ],
            [
                'id' => $generateCustomId('U'),
                'email' => 'parent2@ppdb.test',
                'password' => Hash::make('01012012'),
                'tipe_akun' => 'U',
                'no_telp' => '081987654321',
                'name' => 'Siti Rahmawati',
                'tanggal_lahir' => '1982-01-01',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kenanga No. 34, Jakarta',
                'kelurahan' => 'Menteng',
                'kecamatan' => 'Tanah Abang',
                'id_sekolah' => null,
            ],
        ];

        foreach ($akunOrtu as $data) {
            Akun::updateOrCreate(['email' => $data['email']], $data);
        }

        $this->command->info('✅ Seeder AkunUserSeeder berhasil dijalankan!');
    }
}
