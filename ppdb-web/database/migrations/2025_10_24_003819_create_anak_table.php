<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('id_akun_orangtua');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->decimal('rerata_rapor', 5, 2)->nullable();
            $table->text('prestasi')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('nik')->unique();
            $table->string('no_kk')->unique();
            $table->string('no_akta_lahir')->nullable();
            $table->string('tempat_tinggal')->nullable();
            $table->string('moda_transportasi')->nullable();
            $table->integer('jarak_rumah')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->foreign('id_akun_orangtua')->references('id')->on('akun')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
