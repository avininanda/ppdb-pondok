<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // unique supaya tidak ada nomor pendaftaran kembar
            $table->string('nomor_pendaftaran')->nullable()->unique()->after('periode_pendaftaran_id');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('nomor_pendaftaran');
        });
    }
};