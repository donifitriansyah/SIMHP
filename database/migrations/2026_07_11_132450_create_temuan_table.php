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
        Schema::create('temuan', function (Blueprint $table) {

            $table->id();


            $table->foreignId('lhp_id')
                ->constrained('lhp')
                ->cascadeOnDelete();



            $table->string('nomor_temuan', 50);



            $table->text('uraian_temuan');



            $table->text('administrasi')
                ->nullable();



            $table->decimal(
                'nilai_kerugian',
                15,
                2
            )
                ->nullable();



            $table->string('nama_pelaku', 150)
                ->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuan');
    }
};
