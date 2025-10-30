<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenis')->unique(); // contoh: JD-SD, JD-SMP
            $table->string('nama_jenis');
            $table->integer('kuota')->default(0);
            $table->integer('sisa_kuota')->default(0);
            $table->integer('kapasitas')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->string('akun_id')->nullable()->index();
            $table->foreign('akun_id')->references('id')->on('akun')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_sekolah');
    }
};
