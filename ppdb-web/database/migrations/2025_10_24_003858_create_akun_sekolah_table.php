<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('akun_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('akun_id');
            $table->integer('sekolah_id');
            $table->enum('role_in_school', ['admin', 'panitia'])->default('admin');
            $table->timestamps();

            $table->unique(['akun_id', 'sekolah_id']);
            $table->foreign('akun_id')->references('id')->on('akun')->cascadeOnDelete();
            $table->foreign('sekolah_id')->references('id')->on('sekolah')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun_sekolah');
    }
};
