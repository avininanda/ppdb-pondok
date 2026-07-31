<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedTinyInteger('anak_ke')->nullable()->after('alamat');
            $table->text('riwayat_penyakit')->nullable()->after('anak_ke');
            $table->string('pas_foto')->nullable()->after('file_ijazah');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['anak_ke', 'riwayat_penyakit', 'pas_foto']);
        });
    }
};
