<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TindakLanjut;


class TindakLanjutSeeder extends Seeder
{

    public function run(): void
    {


        TindakLanjut::create([

            'rekomendasi_id' => 1,

            'status_id' => 2,

            'narasi' => 'Sedang dilakukan proses penyelesaian',

            'nilai_pengembalian' => 25000000,

            'nilai_setor_pajak' => 0,

            'tanggal_validasi' => null,

            'validator' => null


        ]);
    }
}
