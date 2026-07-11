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
        Schema::create('dokumen_tindak_lanjut', function (Blueprint $table) {

            $table->id();


            $table->foreignId('tindak_lanjut_id')
                ->constrained('tindak_lanjut')
                ->cascadeOnDelete();



            $table->string('nama_file', 255);


            $table->string('path_file', 255);


            $table->string('tipe_file', 20)
                ->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_tindak_lanjut');
    }
};
