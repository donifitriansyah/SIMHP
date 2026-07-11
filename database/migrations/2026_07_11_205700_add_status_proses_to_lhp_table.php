<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->enum('status_proses', [

                'nihil',
                'belum_diproses',
                'dalam_proses',
                'selesai'

            ])
                ->default('belum_diproses')
                ->after('status_lhp');
        });
    }



    public function down()
    {
        Schema::table('lhp', function (Blueprint $table) {

            $table->dropColumn('status_proses');
        });
    }
    
};
