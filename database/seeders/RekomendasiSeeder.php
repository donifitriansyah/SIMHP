<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rekomendasi;


class RekomendasiSeeder extends Seeder
{

    public function run(): void
    {


        Rekomendasi::create([

            'temuan_id' => 1,

            'uraian_rekomendasi' => 'Melakukan pengembalian ke kas daerah',

            'administrasi' => 'Melengkapi dokumen',

            'nilai_finansial' => 50000000


        ]);
    }
}
