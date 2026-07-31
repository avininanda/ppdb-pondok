<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            // Ketika user dihapus, data pendaftarannya ikut terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data diri calon santri
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->string('no_telepon');
            $table->text('hafalan')->nullable();   // nullable = boleh kosong
            $table->text('alamat');

            // Data orang tua
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('hp_ortu');

            // Upload dokumen
            // Hanya simpan PATH file nya, bukan file nya langsung
            $table->string('file_kk')->nullable();
            $table->string('file_akte')->nullable();
            $table->string('file_ijazah')->nullable();

            // Status verifikasi oleh panitia
            // pending = belum diverifikasi
            // diterima = lolos seleksi
            // ditolak = tidak lolos
            $table->enum('status_verifikasi', ['pending', 'diverifikasi', 'diterima', 'ditolak'])
                  ->default('pending');
            $table->text('catatan')->nullable(); // catatan dari panitia

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};