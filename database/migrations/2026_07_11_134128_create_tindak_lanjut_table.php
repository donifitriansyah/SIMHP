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
        Schema::create('tindak_lanjut', function (Blueprint $table) {

            $table->id();


            $table->foreignId('rekomendasi_id')
                ->constrained('rekomendasi')
                ->cascadeOnDelete();



            $table->foreignId('status_id')
                ->constrained('status_tindak_lanjut')
                ->cascadeOnDelete();



            $table->text('narasi')
                ->nullable();



            $table->decimal(
                'nilai_pengembalian',
                15,
                2
            )
                ->nullable();



            $table->decimal(
                'nilai_setor_pajak',
                15,
                2
            )
                ->nullable();



            $table->date('tanggal_validasi')
                ->nullable();



            $table->string('validator', 100)
                ->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};
