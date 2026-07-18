<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lhp;
use App\Models\Temuan;

class TemuanSeeder extends Seeder
{
    public function run(): void
    {

        $lhps = Lhp::orderBy('id')->get();


        foreach ($lhps as $index => $lhp) {


            /*
            |--------------------------------------------------------------------------
            | LHP NIHIL
            |--------------------------------------------------------------------------
            |
            | LHP ke 5 dan 10 internal/eksternal dibuat nihil
            |
            */


            if (($index + 1) % 5 == 0) {


                $lhp->update([

                    'status_proses' => 'nihil',

                    'status_lhp' => 'lengkap'

                ]);


                continue;

            }



            /*
            |--------------------------------------------------------------------------
            | LHP MEMILIKI TEMUAN
            |--------------------------------------------------------------------------
            */


            $jumlahTemuan = rand(1, 3);



            for ($i = 1; $i <= $jumlahTemuan; $i++) {


                /*
                |--------------------------------------------------------------------------
                | Nilai kerugian realistis
                |--------------------------------------------------------------------------
                */


                $nilaiKerugian = [

                    10000000,

                    25000000,

                    50000000,

                    75000000

                ];



                $nilai = $nilaiKerugian[array_rand($nilaiKerugian)];



                Temuan::create([


                    'lhp_id' => $lhp->id,


                    // nomor hanya 1,2,3
                    'nomor_temuan' => $i,



                    'uraian_temuan' =>
                        'Terdapat ketidaksesuaian hasil pemeriksaan pada '
                        .$lhp->objek_pemeriksaan,



                    'administrasi' =>
                        'Dokumen pendukung belum lengkap',



                    'nilai_kerugian' =>
                        $nilai,



                    'nama_pelaku' =>
                        $lhp->instansi_pemeriksa == 'Itkab'
                            ? 'Budi Santoso'
                            : $lhp->nama_pejabat_eksternal,


                ]);


            }



            /*
            |--------------------------------------------------------------------------
            | Status awal
            |--------------------------------------------------------------------------
            */

            $lhp->update([

                'status_proses' => 'dalam_proses',

                'status_lhp' => 'tidak_lengkap'

            ]);


        }

    }
}
