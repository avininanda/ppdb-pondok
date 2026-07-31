<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel pendaftarans
            // Satu pendaftaran punya satu jadwal wawancara
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');

            $table->date('tanggal_tes');
            $table->time('jam_tes');
            $table->string('link_tes'); // link Google Meet

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};