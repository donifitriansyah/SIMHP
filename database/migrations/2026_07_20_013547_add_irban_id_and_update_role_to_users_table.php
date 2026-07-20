<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Update enum role
            $table->enum('role', [
                'super_user',
                'user_entry',
                'user_view',
            ])->default('user_entry')->change();

            // Tambahkan relasi ke irban
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

            $table->enum('role', [
                'super_user',
                'user_entry',
            ])->default('user_entry')->change();
        });
    }
};
