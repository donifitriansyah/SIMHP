<?php

namespace Database\Seeders;

use App\Models\Lhp;
use App\Models\Rekomendasi;
use App\Models\TindakLanjut;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TindakLanjutSeeder extends Seeder
{
    public function run(): void
    {

        $rekomendasis = Rekomendasi::all();


        foreach ($rekomendasis as $rekomendasi) {


            TindakLanjut::create([

                'rekomendasi_id' => $rekomendasi->id,

                'status_id' => 2,

                'narasi' =>
                'Telah dilakukan proses tindak lanjut.',

                'nilai_pengembalian' => 2000000,

                'nilai_setor_pajak' => 250000,

                'validator' => null,

                'tanggal_validasi' => null,

                'keterangan' =>
                'Masih dalam proses.'

            ]);



            TindakLanjut::create([

                'rekomendasi_id' => $rekomendasi->id,

                'status_id' => 3,

                'narasi' =>
                'Rekomendasi telah selesai ditindaklanjuti.',

                'nilai_pengembalian' =>
                $rekomendasi->nilai_finansial,

                'nilai_setor_pajak' =>
                $rekomendasi->nilai_pajak,

                'validator' =>
                'Doni Fitriansyah',

                'tanggal_validasi' =>
                Carbon::now()->subDays(5),

                'keterangan' =>
                'Telah diverifikasi dan selesai.'

            ]);
        }



        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS SEMUA LHP
        |--------------------------------------------------------------------------
        */

        foreach (Lhp::all() as $lhp) {

            $lhp->updateStatusProses();
        }
    }
}
