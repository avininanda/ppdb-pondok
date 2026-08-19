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
    \DB::statement("ALTER TABLE pendaftarans 
        MODIFY COLUMN status_akhir 
        ENUM('belum_ada','diterima','ditolak','wawancara_ulang') 
        DEFAULT 'belum_ada'");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
