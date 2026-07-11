<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('irban', function (Blueprint $table) {

            $table->string('nama_inspektur_pembantu', 150)
                  ->nullable()
                  ->after('nama_irban');

        });

    }


    public function down(): void
    {

        Schema::table('irban', function (Blueprint $table) {

            $table->dropColumn('nama_inspektur_pembantu');

        });

    }

};
