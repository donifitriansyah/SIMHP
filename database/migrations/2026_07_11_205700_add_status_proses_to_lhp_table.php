<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
    ALTER TABLE lhp
    MODIFY COLUMN status_proses
    ENUM(
        'tt',
        'belum_ditindaklanjuti',
        'dalam_proses',
        'selesai'
    )
    DEFAULT 'belum_ditindaklanjuti'
");


        // ubah data lama jika sudah ada
        DB::table('lhp')
            ->where('status_proses', 'nihil')
            ->update([
                'status_proses' => 'tt'
            ]);
    }


    public function down(): void
    {
        DB::statement("
    ALTER TABLE lhp
    MODIFY COLUMN status_proses
    ENUM(
        'tt',
        'belum_ditindaklanjuti',
        'dalam_proses',
        'selesai'
    )
    DEFAULT 'belum_ditindaklanjuti'
");
    }
};
