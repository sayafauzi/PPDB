<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{
    Akun,
    Sekolah,
    AkunSekolah,
    JenisSekolah,
    Anak,
    Registrasi
};
use App\Helpers\IdGenerator;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // 1️⃣ Buat Sekolah
        // =========================================================
        $sekolah1 = Sekolah::create([
            'kode_sekolah' => 'SCH-001',
            'nama_sekolah' => 'Yayasan Harapan Bangsa',
            'type' => 'Yayasan',
            'alamat' => 'Jl. Merdeka No. 1',
            'kontak' => '08123456789',
            'biaya_pendaftaran' => 150000,
            'biaya_awal' => 500000,
            'biaya_spp' => 300000,
            'status_aktif' => true,
        ]);

        $sekolah2 = Sekolah::create([
            'kode_sekolah' => 'SCH-002',
            'nama_sekolah' => 'Yayasan Cendekia Utama',
            'type' => 'Yayasan',
            'alamat' => 'Jl. Pelajar No. 5',
            'kontak' => '082233445566',
            'biaya_pendaftaran' => 200000,
            'biaya_awal' => 750000,
            'biaya_spp' => 400000,
            'status_aktif' => true,
        ]);

        // =========================================================
        // 2️⃣ Buat Jenis Sekolah untuk setiap sekolah
        // =========================================================
        $sd = JenisSekolah::create([
            'kode_jenis' => 'JD-SD',
            'nama_jenis' => 'Sekolah Dasar (SD)',
            'kuota' => 50,
            'sisa_kuota' => 50,
            'kapasitas' => 60,
            'status_aktif' => true,
            'sekolah_id' => $sekolah1->id,
        ]);

        $smp = JenisSekolah::create([
            'kode_jenis' => 'JD-SMP',
            'nama_jenis' => 'Sekolah Menengah Pertama (SMP)',
            'kuota' => 40,
            'sisa_kuota' => 40,
            'kapasitas' => 50,
            'status_aktif' => true,
            'sekolah_id' => $sekolah2->id,
        ]);

        // =========================================================
        // 3️⃣ Buat Akun
        // =========================================================
        $superadmin = Akun::create([
            'id' => IdGenerator::generateAkunId('SU'),
            'email' => 'superadmin@ppdb.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'SU',
            'name' => 'Super Admin',
        ]);

        $admin1 = Akun::create([
            'id' => IdGenerator::generateAkunId('A'),
            'email' => 'admin@harapan.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'A',
            'name' => 'Admin SD Harapan Bangsa',
        ]);

        $admin2 = Akun::create([
            'id' => IdGenerator::generateAkunId('A'),
            'email' => 'admin@cendekia.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'A',
            'name' => 'Admin SMP Cendekia Utama',
        ]);

        $ortu = Akun::create([
            'id' => IdGenerator::generateAkunId('U'),
            'email' => 'ortu@ppdb.test',
            'password' => Hash::make('password'),
            'tipe_akun' => 'U',
            'name' => 'Orang Tua Siswa',
        ]);

        // =========================================================
        // 4️⃣ Relasi AkunSekolah (admin ↔ sekolah)
        // =========================================================
        AkunSekolah::create([
            'akun_id' => $admin1->id,
            'sekolah_id' => $sekolah1->id,
            'role_in_school' => 'admin',
        ]);

        AkunSekolah::create([
            'akun_id' => $admin2->id,
            'sekolah_id' => $sekolah2->id,
            'role_in_school' => 'admin',
        ]);

        // =========================================================
        // 5️⃣ Anak (milik orang tua)
        // =========================================================
        // $anak = Anak::create([
        //     'nama_lengkap' => 'Ahmad Fajar',
        //     'tanggal_lahir' => '2014-05-12',
        //     'jenis_kelamin' => 'L',
        //     'akun_id' => $ortu->id,
        // ]);

        // // =========================================================
        // // 6️⃣ Registrasi (anak mendaftar ke SD Harapan Bangsa)
        // // =========================================================
        // Registrasi::create([
        //     'id_anak' => $anak->id,
        //     'id_sekolah' => $sekolah1->id,
        //     'jenis_sekolah_id' => $sd->id,
        //     'status' => 'menunggu_pembayaran',
        //     'nominal_transfer' => $sekolah1->biaya_pendaftaran,
        //     'waktu_daftar' => now(),
        //     'kode_transaksi' => 'TX-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6)),
        // ]);
    }
}
