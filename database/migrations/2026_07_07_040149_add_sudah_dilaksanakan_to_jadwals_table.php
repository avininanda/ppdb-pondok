<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->boolean('sudah_dilaksanakan')->default(false)->after('link_tes');
        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn('sudah_dilaksanakan');
        });
    }
};