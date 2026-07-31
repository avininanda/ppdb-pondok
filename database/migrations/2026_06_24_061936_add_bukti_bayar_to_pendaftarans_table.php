<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('file_bukti_bayar')->nullable()->after('file_ijazah');
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'terverifikasi'])
                  ->default('belum_bayar')
                  ->after('file_bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('file_bukti_bayar');
            $table->dropColumn('status_pembayaran');
        });
    }
};