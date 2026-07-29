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
        Schema::create('lhp_pejabat_auditee', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lhp_id')
                ->constrained('lhp')
                ->cascadeOnDelete();

            $table->foreignId('auditee_id')
                ->constrained('auditee')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhp_pejabat_auditee');
    }
};
