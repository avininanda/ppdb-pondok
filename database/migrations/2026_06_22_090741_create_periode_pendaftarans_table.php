<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_pendaftarans', function (Blueprint $table) {
            $table->id();

            $table->string('tahun_ajaran'); // contoh: "2026/2027"
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');

            // Hanya 1 periode yang aktif dalam satu waktu
            $table->boolean('is_aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_pendaftarans');
    }
};