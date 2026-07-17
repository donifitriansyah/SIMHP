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

            $table->enum('instansi_pemeriksa', [
                'Itkab',
                'Itprov',
                'BPK RI',
                'BPKP'
            ])
            ->default('Itkab')
            ->after('jenis_pemeriksaan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->dropColumn('instansi_pemeriksa');

        });
    }
};
