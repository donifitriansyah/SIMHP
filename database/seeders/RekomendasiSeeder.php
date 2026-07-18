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


        foreach ($temuans as $temuan) {


            $nilaiFinansial = $temuan->nilai_kerugian ?? 0;


            /*
            |--------------------------------------------------------------------------
            | Nilai Pajak Maksimal 10% dari Nilai Finansial
            |--------------------------------------------------------------------------
            */

            $nilaiPajak = $nilaiFinansial > 0
                ? $nilaiFinansial * 0.10
                : 0;



            Rekomendasi::create([


                'temuan_id' => $temuan->id,


                'uraian_rekomendasi' =>
                    'Kepada pihak terkait agar melakukan tindak lanjut '
                    .'dan menyelesaikan permasalahan atas temuan nomor '
                    .$temuan->nomor_temuan,



                'administrasi' =>
                    'Melengkapi dokumen pendukung sesuai ketentuan yang berlaku',



                'nilai_finansial' =>
                    $nilaiFinansial,



                'nilai_pajak' =>
                    $nilaiPajak,


            ]);


        }

    }
}
