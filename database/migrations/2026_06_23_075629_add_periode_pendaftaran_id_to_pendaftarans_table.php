<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // nullable karena data pendaftar lama (sebelum kolom ini ada) belum punya periode
            // nullOnDelete: kalau periode dihapus, pendaftar TIDAK ikut terhapus,
            // cuma kehilangan label periodenya saja
            $table->foreignId('periode_pendaftaran_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('periode_pendaftarans')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['periode_pendaftaran_id']);
            $table->dropColumn('periode_pendaftaran_id');
        });
    }
};