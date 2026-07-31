<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedTinyInteger('jumlah_revisi')->default(0)->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('jumlah_revisi');
        });
    }
};