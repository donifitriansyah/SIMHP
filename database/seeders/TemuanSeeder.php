<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lhp;
use App\Models\Temuan;

class TemuanSeeder extends Seeder
{
    public function run(): void
    {

        $lhps = Lhp::all();


        foreach($lhps as $lhp){


            for($i=1;$i<=2;$i++){


                Temuan::create([

                    'lhp_id'=>$lhp->id,

                    'nomor_temuan'=>$i,

                    'uraian_temuan'=>
                    'Terdapat ketidaksesuaian administrasi dan realisasi pekerjaan pada pemeriksaan '.$lhp->nomor_lhp,

                    'administrasi'=>
                    'Dokumen belum lengkap',

                    'nilai_kerugian'=>
                    5000000,

                    'nama_pelaku'=>
                    'Budi Santoso'

                ]);

            }

        }

    }
}
