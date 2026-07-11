<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auditee;


class AuditeeSeeder extends Seeder
{

    public function run(): void
    {

        Auditee::insert([

            [
                'nama_dinas' => 'Dinas Pekerjaan Umum dan Tata Ruang',
                'alamat' => 'Kabupaten Ketapang'
            ],

            [
                'nama_dinas' => 'Dinas Pendidikan',
                'alamat' => 'Kabupaten Ketapang'
            ],

            [
                'nama_dinas' => 'Dinas Kesehatan',
                'alamat' => 'Kabupaten Ketapang'
            ]

        ]);
    }
}
