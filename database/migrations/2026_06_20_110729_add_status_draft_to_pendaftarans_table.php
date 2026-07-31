<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // draft   = sedang diisi, belum disubmit
            // submit  = sudah disubmit, menunggu verifikasi panitia
            $table->enum('status_draft', ['draft', 'submit'])
                  ->default('draft')
                  ->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('status_draft');
        });
    }
};