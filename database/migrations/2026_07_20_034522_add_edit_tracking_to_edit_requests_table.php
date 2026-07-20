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
        Schema::table('edit_requests', function (Blueprint $table) {

            $table->boolean('edit_lhp')
                ->default(false);

            $table->boolean('edit_temuan')
                ->default(false);

            $table->boolean('edit_rekomendasi')
                ->default(false);

            $table->boolean('edit_tindak_lanjut')
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edit_requests', function (Blueprint $table) {
            //
        });
    }
};
