<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE lhp
            MODIFY COLUMN jenis_pemeriksaan
            ENUM(
                'PKPT',
                'PDTT',
                'KASUS',
                'KINERJA',
                'KETAATAN',
                'SPI'
            )
        ");
    }


    public function down(): void
    {
        DB::statement("
            ALTER TABLE lhp
            MODIFY COLUMN jenis_pemeriksaan
            ENUM(
                'PKPT',
                'PDTT',
                'KASUS'
            )
        ");
    }
};
