<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            $table->decimal('nilai_akhir', 5, 2)->nullable()->after('hasil');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            $table->dropColumn('nilai_akhir');
        });
    }
};