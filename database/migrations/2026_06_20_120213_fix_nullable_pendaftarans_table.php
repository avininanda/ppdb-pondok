<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Kolom data orang tua boleh kosong dulu
            // karena baru diisi di step 2
            $table->string('nama_ayah')->nullable()->change();
            $table->string('pekerjaan_ayah')->nullable()->change();
            $table->string('nama_ibu')->nullable()->change();
            $table->string('pekerjaan_ibu')->nullable()->change();
            $table->string('hp_ortu')->nullable()->change();

            // Kolom dokumen boleh kosong dulu
            // karena baru diisi di step 3
            $table->string('file_kk')->nullable()->change();
            $table->string('file_akte')->nullable()->change();
            $table->string('file_ijazah')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('nama_ayah')->nullable(false)->change();
            $table->string('pekerjaan_ayah')->nullable(false)->change();
            $table->string('nama_ibu')->nullable(false)->change();
            $table->string('pekerjaan_ibu')->nullable(false)->change();
            $table->string('hp_ortu')->nullable(false)->change();
            $table->string('file_kk')->nullable(false)->change();
            $table->string('file_akte')->nullable(false)->change();
            $table->string('file_ijazah')->nullable(false)->change();
        });
    }
};