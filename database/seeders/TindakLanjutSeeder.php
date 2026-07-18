<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Rekomendasi;
use App\Models\TindakLanjut;



class TindakLanjutSeeder extends Seeder
{

    public function run(): void
    {


        $rekomendasis = Rekomendasi::all();


        foreach($rekomendasis as $index=>$rekomendasi){


            // tindak lanjut pertama

            TindakLanjut::create([

                'rekomendasi_id'=>$rekomendasi->id,


                'status_id'=>2,


                'narasi'=>
                'Sedang dilakukan proses tindak lanjut rekomendasi',


                'nilai_pengembalian'=>2000000,


                'nilai_setor_pajak'=>0,


                'validator'=>'Doni',


                'keterangan'=>
                'Dalam proses verifikasi',

                'tanggal_validasi'=>now()


            ]);



            // sebagian dibuat selesai

            if($index % 3 == 0){


                TindakLanjut::create([


                    'rekomendasi_id'=>$rekomendasi->id,


                    'status_id'=>3,


                    'narasi'=>
                    'Rekomendasi telah selesai dilaksanakan',


                    'nilai_pengembalian'=>3000000,


                    'nilai_setor_pajak'=>500000,


                    'validator'=>'Doni',


                    'keterangan'=>
                    'Telah diverifikasi dan dinyatakan selesai',


                    'tanggal_validasi'=>now()


                ]);

            }


        }


    }

}
