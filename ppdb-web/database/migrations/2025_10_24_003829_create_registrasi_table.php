<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registrasi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_anak');
            $table->integer('id_sekolah');
            $table->enum('status', [
                'menunggu_pembayaran','menunggu_konfirmasi','bukti_bayar_ditolak',
                'pendaftaran_batal','dibayar','lulus_tes_akademik',
                'lulus','lulus_bersyarat','cadangan','belum_diterima'
            ])->nullable()->default('menunggu_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('waktu_daftar')->nullable();
            $table->dateTime('deadline_bayar')->nullable();
            $table->integer('nominal_transfer')->nullable();
            $table->string('kode_transaksi')->nullable();
            
            $table->foreign('id_anak')->references('id')->on('anak')->cascadeOnDelete();
            $table->foreign('id_sekolah')->references('id')->on('sekolah')->cascadeOnDelete();
            $table->foreignId('jenis_sekolah_id')->nullable()->constrained('jenis_sekolah')->nullOnDelete();
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
