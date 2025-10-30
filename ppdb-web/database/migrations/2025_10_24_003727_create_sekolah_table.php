<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sekolah')->unique();
            $table->string('nama_sekolah');
            $table->string('type')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('no_rekening')->nullable();
            $table->text('syarat')->nullable();
            $table->string('link_grup')->nullable();
            $table->integer('biaya_pendaftaran')->default(0);
            $table->integer('biaya_awal')->default(0);
            $table->integer('biaya_spp')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->foreignId('jenis_sekolah_id')->nullable()->constrained('jenis_sekolah')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
