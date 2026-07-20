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

            $table->foreignId('irban_id')
                ->nullable()
                ->after('role')
                ->constrained('irban')
                ->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['irban_id']);

            $table->dropColumn('irban_id');
        });
    }
};
