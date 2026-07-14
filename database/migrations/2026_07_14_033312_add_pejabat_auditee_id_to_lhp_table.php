<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->foreignId('pejabat_auditee_id')
                ->nullable()
                ->after('auditee_id')
                ->constrained('pejabat_auditee')
                ->cascadeOnUpdate()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->dropForeign(['pejabat_auditee_id']);
            $table->dropColumn('pejabat_auditee_id');

        });
    }
};
