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
        Schema::create('lhp', function (Blueprint $table) {

            $table->id();


            $table->foreignId('irban_id')
                ->constrained('irban')
                ->cascadeOnDelete();



            $table->foreignId('auditee_id')
                ->constrained('auditee')
                ->cascadeOnDelete();



            $table->foreignId('pihak_ketiga_id')
                ->nullable()
                ->constrained('pihak_ketiga')
                ->nullOnDelete();



            $table->foreignId('objek_pemeriksaan_id')
                ->constrained('objek_pemeriksaan')
                ->cascadeOnDelete();



            $table->string('nomor_lhp', 100);


            $table->date('tanggal_lhp');


            $table->string('nomor_spt', 100)
                ->nullable();


            $table->date('tanggal_spt')
                ->nullable();


            $table->year('tahun_pkpt')
                ->nullable();



            $table->decimal(
                'jumlah_dana_diawasi',
                15,
                2
            )
                ->nullable();



            $table->enum('jenis_pemeriksaan', [

                'PKPT',
                'PDTT',
                'KASUS'

            ]);



            $table->enum('status_lhp', [

                'lengkap',
                'tidak_lengkap'

            ])
                ->default('tidak_lengkap');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhp');
    }
};
