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
        Schema::table('lhp', function (Blueprint $table) {
            $table->string('jenis_laporan', 10)
                ->default('LHP')
                ->after('instansi_pemeriksa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lhp', function (Blueprint $table) {
            //
        });
    }
};
