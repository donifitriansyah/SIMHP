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

        Schema::table('users', function (Blueprint $table) {


            // username untuk login SIMHP
            $table->string('username', 50)
                  ->unique()
                  ->after('name');


            // hak akses pengguna
            $table->enum('role', [

                'super_user',
                'user_entry'

            ])
            ->default('user_entry')
            ->after('password');


            // status aktif pengguna
            $table->boolean('status')
                  ->default(true)
                  ->after('role');


        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {


            $table->dropUnique([
                'username'
            ]);


            $table->dropColumn([

                'username',
                'role',
                'status'

            ]);


        });

    }

};
