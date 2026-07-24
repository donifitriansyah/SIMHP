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
        Schema::create('register_nomor_lhp', function (Blueprint $table) {

            $table->id();

            // Tim Pemeriksa (Irban)
            $table->foreignId('irban_id')
                ->constrained('irban')
                ->cascadeOnDelete();

            // Jenis Dokumen
            $table->enum('jenis_dokumen', [
                'LHP',
                'LHR',
                'LHE',
                'LHM',
                'LHK',
                'LHA'
            ]);

            // Nomor Register
            $table->string('nomor_dokumen')->unique();

            // Surat Perintah Tugas
            $table->string('nomor_spt');
            $table->date('tanggal_spt');

            // Tahun Pemeriksaan
            $table->year('tahun_pemeriksaan');

            // Anggaran Pemeriksaan
            $table->decimal('anggaran_pemeriksaan', 18, 2)
                ->nullable();

            // Objek Pemeriksaan
            $table->string('objek_pemeriksaan');

            // Dana yang diawasi
            $table->decimal('dana_diawasi', 18, 2)
                ->nullable();

            // Nama pimpinan objek pemeriksaan
            $table->string('nama_pimpinan');

            // Ringkasan Temuan
            $table->text('temuan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_nomor_lhp');
    }
};
