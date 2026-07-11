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
        Schema::create('rekomendasi', function (Blueprint $table) {

            $table->id();


            $table->foreignId('temuan_id')
                ->constrained('temuan')
                ->cascadeOnDelete();



            $table->text('uraian_rekomendasi');



            $table->text('administrasi')
                ->nullable();



            $table->decimal(
                'nilai_finansial',
                15,
                2
            )
                ->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
