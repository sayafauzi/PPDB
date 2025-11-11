<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->foreignId('jenis_sekolah_id')
                ->nullable()
                ->constrained('jenis_sekolah')
                ->nullOnDelete()
                ->after('status_aktif'); // opsional: letakkan di posisi tertentu
        });
    }

    public function down(): void
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->dropForeign(['jenis_sekolah_id']);
            $table->dropColumn('jenis_sekolah_id');
        });
    }
};
