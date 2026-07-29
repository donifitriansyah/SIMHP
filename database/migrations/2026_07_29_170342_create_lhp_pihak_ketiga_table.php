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
        Schema::create('lhp_pihak_ketiga', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lhp_id')
                ->constrained('lhp')
                ->cascadeOnDelete();

            $table->foreignId('pihak_ketiga_id')
                ->constrained('pihak_ketiga')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhp_pihak_ketiga');
    }
};
