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
        Schema::create('kriteria_penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');
            // contoh: Bacaan Al-Qur'an, Tajwid, Motivasi, Karakter
            $table->text('deskripsi')->nullable();
            $table->integer('bobot')->default(25);
            // bobot dalam persen, total harus 100
            $table->boolean('is_aktif')->default(true);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaians');
    }
};
