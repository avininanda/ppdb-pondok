<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periode_pendaftarans', function (Blueprint $table) {
            $table->date('tanggal_tes_mulai')->nullable()->after('tanggal_tutup');
            $table->date('tanggal_tes_selesai')->nullable()->after('tanggal_tes_mulai');
            $table->date('tanggal_pengumuman')->nullable()->after('tanggal_tes_selesai');
            $table->date('tanggal_daftar_ulang_mulai')->nullable()->after('tanggal_pengumuman');
            $table->date('tanggal_daftar_ulang_selesai')->nullable()->after('tanggal_daftar_ulang_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('periode_pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_tes_mulai',
                'tanggal_tes_selesai',
                'tanggal_pengumuman',
                'tanggal_daftar_ulang_mulai',
                'tanggal_daftar_ulang_selesai',
            ]);
        });
    }
};