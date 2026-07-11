<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PejabatAuditee;


class PejabatAuditeeSeeder extends Seeder
{

    public function run(): void
    {


        PejabatAuditee::insert([

            [
                'auditee_id' => 1,
                'jenis_jabatan' => 'pimpinan',
                'nama' => 'Budi Santoso',
                'tahun' => 2026
            ],

            [
                'auditee_id' => 1,
                'jenis_jabatan' => 'ppk',
                'nama' => 'Ahmad Hidayat',
                'tahun' => 2026
            ],

            [
                'auditee_id' => 1,
                'jenis_jabatan' => 'pptk',
                'nama' => 'Rudi Hartono',
                'tahun' => 2026
            ]


        ]);
    }
}
