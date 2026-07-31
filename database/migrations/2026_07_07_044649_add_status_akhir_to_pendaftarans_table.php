<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('status_akhir', ['belum_ada', 'diterima', 'ditolak'])
                  ->default('belum_ada')
                  ->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('status_akhir');
        });
    }
};