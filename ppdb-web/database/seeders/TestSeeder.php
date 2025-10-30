<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{Akun, Sekolah, AkunSekolah, JenisSekolah, Anak, Registrasi};
use App\Helpers\IdGenerator;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Jenis Sekolah
        $sd = JenisSekolah::create([
            'kode_jenis' => 'JD-SD',
            'nama_jenis' => 'Sekolah Dasar',
            'kuota' => 50,
            'sisa_kuota' => 50,
            'kapasitas' => 60,
            'status_aktif' => true,
        ]);

        $smp = JenisSekolah::create([
            'kode_jenis' => 'JD-SMP',
            'nama_jenis' => 'Sekolah Menengah Pertama',
            'kuota' => 40,
            'sisa_kuota' => 40,
            'kapasitas' => 50,
            'status_aktif' => true,
        ]);

        // 2️⃣ Sekolah
        $sekolah1 = Sekolah::create([
            'kode_sekolah' => 'SD001',
            'nama_sekolah' => 'SD Harapan Bangsa',
            'type' => 'SD',
            'alamat' => 'Jl. Merdeka No.1',
            'kontak' => '08123456789',
            'biaya_pendaftaran' => 150000,
            'biaya_awal' => 500000,
            'biaya_spp' => 300000,
            'jenis_sekolah_id' => $sd->id,
        ]);

        $sekolah2 = Sekolah::create([
            'kode_sekolah' => 'SMP002',
            'nama_sekolah' => 'SMP Cendekia Utama',
            'type' => 'SMP',
            'alamat' => 'Jl. Pelajar No.5',
            'kontak' => '082233445566',
            'biaya_pendaftaran' => 200000,
            'biaya_awal' => 750000,
            'biaya_spp' => 400000,
            'jenis_sekolah_id' => $smp->id,
        ]);

        // 3️⃣ Akun
        $superadmin = Akun::create([
            'id' => IdGenerator::generateAkunId('SU'),
            'email' => 'superadmin@ppdb.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'SU',
            'name' => 'Super Admin',
        ]);

        $admin = Akun::create([
            'id' => IdGenerator::generateAkunId('A'),
            'email' => 'admin@ppdb.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'A',
            'name' => 'Admin Sekolah 1',
            'id_sekolah' => $sekolah1->id,
        ]);

        $ortu = Akun::create([
            'id' => IdGenerator::generateAkunId('U'),
            'email' => 'ortu@ppdb.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'U',
            'name' => 'Orang Tua Siswa',
        ]);

        // 4️⃣ AkunSekolah (relasi admin ke sekolah)
        AkunSekolah::create([
            'akun_id' => $admin->id,
            'sekolah_id' => $sekolah1->id,
            'role_in_school' => 'admin',
        ]);

        // 5️⃣ Anak
        // $anak = Anak::create([
        //     'nama_lengkap' => 'Ahmad Fajar',
        //     'tanggal_lahir' => '2014-05-12',
        //     'jenis_kelamin' => 'L',
        //     'akun_id' => $ortu->id,
        // ]);

        // // 6️⃣ Registrasi
        // Registrasi::create([
        //     'id_anak' => $anak->id,
        //     'id_sekolah' => $sekolah1->id,
        //     'status' => 'menunggu_pembayaran',
        //     'nominal_transfer' => 150000,
        //     'waktu_daftar' => now(),
        //     'kode_transaksi' => 'TX-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6)),
        // ]);
    }
}
