<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {

            $table->dropForeign(['irban_id']);
            $table->dropColumn('irban_id');

            $table->foreignId('skpd_id')
                ->nullable()
                ->constrained('skpd')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {

            $table->dropForeign(['skpd_id']);
            $table->dropColumn('skpd_id');

            $table->foreignId('irban_id')
                ->nullable()
                ->constrained('irban')
                ->nullOnDelete();
        });
    }
};
