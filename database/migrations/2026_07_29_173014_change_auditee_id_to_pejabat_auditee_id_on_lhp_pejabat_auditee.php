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
        Schema::table('lhp_pejabat_auditee', function (Blueprint $table) {

            $table->dropForeign(['auditee_id']);

            $table->dropColumn('auditee_id');


            $table->foreignId('pejabat_auditee_id')
                ->after('lhp_id')
                ->constrained('pejabat_auditee')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pejabat_auditee_id_on_lhp_pejabat_auditee', function (Blueprint $table) {
            //
        });
    }
};
