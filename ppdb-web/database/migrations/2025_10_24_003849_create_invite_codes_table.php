<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invite_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('target_tipe', ['A'])->default('A');
            $table->dateTime('expired_at')->nullable();
            $table->boolean('is_used')->default(false);
            $table->timestamps();

            // $table->foreignId('created_by')->nullable()->constrained('akun')->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invite_codes');
    }
};
