<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('akun_sekolah', function (Blueprint $table) {
            // Hapus constraints lama karena akan bentrok saat kita refactor
            $table->dropForeign(['sekolah_id']);
            $table->dropForeign(['akun_id']);
            $table->dropUnique(['akun_id', 'sekolah_id']);

            $table->dropColumn('sekolah_id');
        });

        Schema::table('akun_sekolah', function (Blueprint $table) {
            // Tambah ulang kolom sekolah_id sebagai FK yang benar
            $table->foreignId('sekolah_id')
                ->constrained('sekolah')
                ->cascadeOnDelete()
                ->after('akun_id');

            $table->unique(['akun_id', 'sekolah_id']);
        });
    }

    public function down(): void
    {
        Schema::table('akun_sekolah', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropUnique(['akun_id', 'sekolah_id']);
            $table->dropColumn('sekolah_id');

            // Kembalikan menjadi integer (jika dibutuhkan)
            $table->integer('sekolah_id');
        });
    }

};
