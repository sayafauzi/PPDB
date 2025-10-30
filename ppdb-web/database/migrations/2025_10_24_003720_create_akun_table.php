<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->string('id')->primary(); // custom format
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->enum('tipe_akun', ['SU', 'A', 'U'])->index();
            $table->string('no_telp')->nullable()->index();
            $table->string('name');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->integer('id_sekolah')->nullable()->index();
            $table->timestamps();

            // $table->foreign('id_sekolah')->references('id')->on('sekolah')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
