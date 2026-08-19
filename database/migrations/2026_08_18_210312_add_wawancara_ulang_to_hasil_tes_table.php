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
    Schema::table('hasil_tes', function (Blueprint $table) {
        // Apakah boleh wawancara ulang?
        $table->boolean('bisa_wawancara_ulang')
              ->default(false)
              ->after('keterangan');

        // Catatan untuk tahapan selanjutnya
        // (baik lulus maupun tidak lulus)
        $table->text('catatan_selanjutnya')
              ->nullable()
              ->after('bisa_wawancara_ulang');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            //
        });
    }
};
