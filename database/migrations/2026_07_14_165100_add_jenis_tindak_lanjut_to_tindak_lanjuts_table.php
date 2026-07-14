<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tindak_lanjut', function (Blueprint $table) {
            $table->enum('jenis_tindak_lanjut', [
                'Reguler',
                'TPKD'
            ])->default('Reguler')->after('status_id');
        });
    }

    public function down(): void
    {
        Schema::table('tindak_lanjut', function (Blueprint $table) {
            $table->dropColumn('jenis_tindak_lanjut');
        });
    }
};
