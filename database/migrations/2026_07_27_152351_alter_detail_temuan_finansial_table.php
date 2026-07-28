<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_temuan_finansial', function (Blueprint $table) {

            $table->foreignId('perangkat_desa_id')
                ->nullable()
                ->after('pegawai_id')
                ->constrained('perangkat_desa')
                ->nullOnDelete();

            $table->foreignId('pihak_lain_id')
                ->nullable()
                ->after('pihak_ketiga_id')
                ->constrained('pihak_lain')
                ->nullOnDelete();

            $table->enum('jenis', [
                'pns',
                'perangkat_desa',
                'penyedia',
                'pihak_lain'
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('detail_temuan_finansial', function (Blueprint $table) {

            $table->dropForeign(['perangkat_desa_id']);
            $table->dropForeign(['pihak_lain_id']);

            $table->dropColumn([
                'perangkat_desa_id',
                'pihak_lain_id'
            ]);

            $table->enum('jenis', [
                'pns',
                'penyedia'
            ])->change();
        });
    }
};
