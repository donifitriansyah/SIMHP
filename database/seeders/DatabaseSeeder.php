<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([

            UserSeeder::class,

            ProfilInspektoratSeeder::class,

            IrbanSeeder::class,

            AuditeeSeeder::class,

            PejabatAuditeeSeeder::class,

            PihakKetigaSeeder::class,

            ObjekPemeriksaanSeeder::class,

            StatusTindakLanjutSeeder::class,

            LhpSeeder::class,

            TemuanSeeder::class,

            RekomendasiSeeder::class,

            TindakLanjutSeeder::class,

            DokumenTindakLanjutSeeder::class,

        ]);
    }
}
