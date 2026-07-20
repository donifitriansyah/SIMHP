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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Modul yang diakses
            $table->string('modul', 50);

            // Jenis aktivitas
            $table->enum('aksi', [
                'Tambah',
                'Edit',
                'Hapus',
                'Login',
                'Logout'
            ]);

            // ID data yang diubah
            $table->unsignedBigInteger('referensi_id')->nullable();

            // Keterangan aktivitas
            $table->text('deskripsi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
