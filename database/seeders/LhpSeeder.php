<?php

namespace Database\Seeders;

use App\Models\Lhp;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LhpSeeder extends Seeder
{
    public function run(): void
    {

        $auditees = \App\Models\Auditee::all();

        $pejabat = \App\Models\PejabatAuditee::all();

        $irbans = \App\Models\Irban::all();


        if (
            $auditees->isEmpty() ||
            $pejabat->isEmpty() ||
            $irbans->isEmpty()
        ) {

            return;
        }


        for ($i = 1; $i <= 20; $i++) {


            Lhp::create([

                'irban_id' => $irbans->random()->id,


                'auditee_id' => $auditees->random()->id,


                'pejabat_auditee_id' => $pejabat->random()->id,


                'pihak_ketiga_id' => null,


                'objek_pemeriksaan' =>
                    'Pemeriksaan Kegiatan Tahun ' . (2025 + $i),



                'nama_pejabat_eksternal' => null,



                'nomor_lhp' =>
                    $i . '/LHP/ITKAB/' . date('Y'),



                'tanggal_lhp' =>
                    Carbon::create(
                        2026,
                        rand(1, 12),
                        rand(1, 28)
                    ),



                'nomor_spt' =>
                    $i . '/SPT/ITKAB/' . date('Y'),



                'tanggal_spt' =>
                    Carbon::create(
                        2026,
                        rand(1, 12),
                        rand(1, 20)
                    ),



                'tahun_pkpt' => 2026,


                'jumlah_dana_diawasi' =>
                    rand(10000000,500000000),



                'jenis_pemeriksaan' =>
                    collect([
                        'pkpt',
                        'pdtt',
                        'kasus'
                    ])->random(),



                'instansi_pemeriksa' =>
                    'Itkab',



                /*
                |--------------------------------------------------------------------------
                | Status Awal
                |--------------------------------------------------------------------------
                */

                'status_lhp' =>
                    'tidak_lengkap',



                'status_proses' =>
                    'belum_diproses',


            ]);

        }

    }
}
