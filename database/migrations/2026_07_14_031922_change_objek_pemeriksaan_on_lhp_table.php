<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->dropForeign(['objek_pemeriksaan_id']);
            $table->dropColumn('objek_pemeriksaan_id');

            $table->string('objek_pemeriksaan')->after('auditee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
