<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE informasis MODIFY COLUMN kategori ENUM('pengumuman', 'persyaratan', 'daftar_ulang') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE informasis MODIFY COLUMN kategori ENUM('pengumuman', 'persyaratan') NOT NULL");
    }
};