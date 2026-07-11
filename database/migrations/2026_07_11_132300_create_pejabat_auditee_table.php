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
        Schema::create('pejabat_auditee', function (Blueprint $table) {

            $table->id();


            $table->foreignId('auditee_id')
                ->constrained('auditee')
                ->cascadeOnDelete();


            $table->enum('jenis_jabatan', [

                'pimpinan',
                'ppk',
                'pptk'

            ]);


            $table->string('nama', 100);


            $table->year('tahun');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pejabat_auditee');
    }
};
