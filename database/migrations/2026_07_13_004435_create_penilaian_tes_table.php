<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_tes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                ->constrained('pendaftarans')
                ->onDelete('cascade');
            $table->foreignId('kriteria_id')
                ->constrained('kriteria_penilaians')
                ->onDelete('cascade');
            $table->enum('nilai_label', [
                'Sangat Baik',
                'Baik',
                'Cukup',
                'Kurang',
                'Sangat Kurang'
            ]);
            // Nilai angka otomatis dari label
            $table->integer('nilai_angka');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_tes');
    }
};
