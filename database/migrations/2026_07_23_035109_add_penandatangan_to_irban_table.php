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
        Schema::table('irban', function (Blueprint $table) {
            $table->string('nama_penandatangan')->nullable()->after('nama_irban');
            $table->string('jabatan_penandatangan')->nullable()->after('nama_penandatangan');
            $table->string('nip_penandatangan', 30)->nullable()->after('jabatan_penandatangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irban', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penandatangan',
                'jabatan_penandatangan',
                'nip_penandatangan',
            ]);
        });
    }
};
