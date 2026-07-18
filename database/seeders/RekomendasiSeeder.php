<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Temuan;
use App\Models\Rekomendasi;


class RekomendasiSeeder extends Seeder
{

    public function run(): void
    {


        $temuans = Temuan::all();


        foreach($temuans as $temuan){


            Rekomendasi::create([


                'temuan_id'=>$temuan->id,


                'uraian_rekomendasi'=>
                'Agar pihak terkait melakukan pengembalian kerugian dan melengkapi administrasi',


                'administrasi'=>
                'Melengkapi dokumen pendukung',


                'nilai_finansial'=>
                5000000,


                'nilai_pajak'=>
                500000


            ]);


        }

    }
}
