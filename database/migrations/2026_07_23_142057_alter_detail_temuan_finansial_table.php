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
        Schema::table('detail_temuan_finansial', function (Blueprint $table) {

            // Hapus kolom lama
            $table->dropColumn([
                'nama_pihak',
                'nama_penyedia',
            ]);

            // Tambahkan relasi ke Pegawai
            $table->foreignId('pegawai_id')
                ->nullable()
                ->after('jenis')
                ->constrained('pegawais')
                ->nullOnDelete();

            // Tambahkan relasi ke Pihak Ketiga
            $table->foreignId('pihak_ketiga_id')
                ->nullable()
                ->after('pegawai_id')
                ->constrained('pihak_ketiga')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_temuan_finansial', function (Blueprint $table) {

            // Hapus foreign key
            $table->dropForeign(['pegawai_id']);
            $table->dropForeign(['pihak_ketiga_id']);

            // Hapus kolom baru
            $table->dropColumn([
                'pegawai_id',
                'pihak_ketiga_id',
            ]);

            // Kembalikan kolom lama
            $table->string('nama_pihak')->nullable()->after('jenis');
            $table->string('nama_penyedia')->nullable()->after('nama_pihak');
        });
    }
};
