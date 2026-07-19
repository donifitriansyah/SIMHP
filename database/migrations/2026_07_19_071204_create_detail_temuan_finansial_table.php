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
        Schema::create('detail_temuan_finansial', function (Blueprint $table) {

            $table->id();

            $table->foreignId('temuan_id')
                ->constrained('temuan')
                ->cascadeOnDelete();


            // jenis detail
            $table->enum('jenis', [
                'pns',
                'penyedia'
            ]);


            // untuk PNS
            $table->string('nama_pihak')
                ->nullable();


            // untuk penyedia
            $table->string('nama_penyedia')
                ->nullable();


            $table->decimal(
                'nilai_temuan',
                15,
                2
            );


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_temuan_finansial');
    }
};
