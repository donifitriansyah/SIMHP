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

            $table->foreignId('auditee_id')
                ->nullable()
                ->change();

            $table->foreignId('pejabat_auditee_id')
                ->nullable()
                ->change();
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
