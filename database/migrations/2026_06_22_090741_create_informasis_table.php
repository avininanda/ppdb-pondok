<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasis', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->text('konten');

            // pengumuman = berita/info terbaru
            // persyaratan = syarat dokumen pendaftaran
            $table->enum('kategori', ['pengumuman', 'persyaratan']);

            // Untuk atur urutan tampil (opsional, kecil tapi berguna)
            $table->integer('urutan')->default(0);

            // Panitia bisa sembunyikan tanpa hapus data
            $table->boolean('is_aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasis');
    }
};