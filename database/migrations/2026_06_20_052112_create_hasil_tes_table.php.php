<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_tes', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel pendaftarans
            // Satu pendaftaran punya satu hasil tes
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');

            // Hasil wawancara: lulus / tidak lulus
            $table->enum('hasil', ['lulus', 'tidak lulus']);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_tes');
    }
};