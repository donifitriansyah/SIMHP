<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_tindak_lanjut', function (Blueprint $table) {

            $table->string('tipe_file', 150)
                ->change();

        });
    }


    public function down(): void
    {
        Schema::table('dokumen_tindak_lanjut', function (Blueprint $table) {

            $table->string('tipe_file', 20)
                ->change();

        });
    }
};
