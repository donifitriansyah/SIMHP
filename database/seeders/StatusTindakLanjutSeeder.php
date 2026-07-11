<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusTindakLanjut;


class StatusTindakLanjutSeeder extends Seeder
{

    public function run(): void
    {

        StatusTindakLanjut::insert([

            [
                'kode' => 'B',
                'nama_status' => 'Belum'
            ],

            [
                'kode' => 'D',
                'nama_status' => 'Dalam Proses'
            ],

            [
                'kode' => 'S',
                'nama_status' => 'Selesai'
            ]


        ]);
    }
}
