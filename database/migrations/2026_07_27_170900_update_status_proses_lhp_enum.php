<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {

        // 1. Tambahkan nilai baru sementara
        DB::statement("
            ALTER TABLE lhp
            MODIFY COLUMN status_proses
            ENUM(
                'nihil',
                'belum_diproses',
                'belum_ditindaklanjuti',
                'dalam_proses',
                'selesai',
                'tt'
            )
            DEFAULT 'belum_diproses'
        ");



        // 2. Migrasi data lama

        DB::table('lhp')
            ->where('status_proses', 'belum_diproses')
            ->update([
                'status_proses' => 'belum_ditindaklanjuti'
            ]);


        DB::table('lhp')
            ->where('status_proses', 'nihil')
            ->update([
                'status_proses' => 'tt'
            ]);



        // 3. Hapus enum lama

        DB::statement("
            ALTER TABLE lhp
            MODIFY COLUMN status_proses
            ENUM(
                'belum_ditindaklanjuti',
                'dalam_proses',
                'selesai',
                'tt'
            )
            DEFAULT 'belum_ditindaklanjuti'
        ");

    }



    public function down(): void
    {
        DB::statement("
            ALTER TABLE lhp
            MODIFY COLUMN status_proses
            ENUM(
                'nihil',
                'belum_diproses',
                'dalam_proses',
                'selesai'
            )
            DEFAULT 'belum_diproses'
        ");
    }

};
