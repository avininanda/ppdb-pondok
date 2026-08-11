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
        // Status orang tua
        $table->enum('status_ortu', [
            'lengkap',      // ayah & ibu ada
            'yatim',        // ayah meninggal
            'piatu',        // ibu meninggal
            'yatim_piatu',  // keduanya meninggal
            'wali',         // diasuh wali
        ])->default('lengkap')->after('alamat');

        // Data wali (opsional, diisi kalau status = wali/yatim_piatu)
        $table->string('nama_wali')->nullable()->after('hp_ortu');
        $table->string('hubungan_wali')->nullable()->after('nama_wali');
        $table->string('hp_wali')->nullable()->after('hubungan_wali');

        // Buat kolom ortu jadi nullable
        $table->string('nama_ayah')->nullable()->change();
        $table->string('pekerjaan_ayah')->nullable()->change();
        $table->string('nama_ibu')->nullable()->change();
        $table->string('pekerjaan_ibu')->nullable()->change();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            //
        });
    }
};
