<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lhp;
use App\Models\Irban;
use App\Models\Auditee;
use App\Models\PejabatAuditee;
use App\Models\PihakKetiga;

class LhpSeeder extends Seeder
{
    public function run(): void
    {

        $irbans = Irban::all();

        $auditees = Auditee::all();

        $pejabats = PejabatAuditee::all();

        $pihakKetiga = PihakKetiga::all();



        /*
        |--------------------------------------------------------------------------
        | LHP INTERNAL 10 DATA
        |--------------------------------------------------------------------------
        */


        for ($i = 1; $i <= 10; $i++) {


            $nihil = in_array($i, [3,7]);



            Lhp::create([


                'irban_id' =>
                    $irbans->random()->id,



                'auditee_id' =>
                    $auditees->random()->id,



                'pejabat_auditee_id' =>
                    $pejabats->random()->id,



                'instansi_pemeriksa' =>
                    'Itkab',



                'nama_pejabat_eksternal' =>
                    null,



                'pihak_ketiga_id' =>
                    null,



                'objek_pemeriksaan' =>
                    'Pemeriksaan Internal OPD '.$i,



                'nomor_lhp' =>
                    $i.'/LHP/ITKAB/2026',



                'tanggal_lhp' =>
                    now()->subDays($i),



                'nomor_spt' =>
                    $i.'/SPT/ITKAB/2026',



                'tanggal_spt' =>
                    now()->subDays($i+5),



                'tahun_pkpt' =>
                    2026,



                'jumlah_dana_diawasi' =>
                    rand(100000000,500000000),



                'jenis_pemeriksaan' =>
                    'pkpt',



                'status_lhp' =>
                    $nihil
                        ? 'lengkap'
                        : 'tidak_lengkap',



                'status_proses' =>
                    $nihil
                        ? 'nihil'
                        : 'belum_diproses',


            ]);


        }





        /*
        |--------------------------------------------------------------------------
        | LHP EKSTERNAL 10 DATA
        |--------------------------------------------------------------------------
        */


        $instansi = [

            'Itprov',

            'BPK RI',

            'BPKP'

        ];



        for ($i = 1; $i <= 10; $i++) {



            $nihil = in_array($i,[2,8]);



            /*
            |--------------------------------------------------------------------------
            | 60% eksternal menggunakan pihak ketiga
            |--------------------------------------------------------------------------
            */

            $gunakanPihakKetiga = $i <= 6;



            Lhp::create([



                'irban_id' =>
                    $irbans->random()->id,



                'auditee_id' =>
                    null,



                'pejabat_auditee_id' =>
                    null,



                'instansi_pemeriksa' =>
                    $instansi[array_rand($instansi)],



                'nama_pejabat_eksternal' =>
                    'Pejabat Eksternal '.$i,



                'pihak_ketiga_id' =>
                    $gunakanPihakKetiga
                        ? $pihakKetiga->random()->id
                        : null,



                'objek_pemeriksaan' =>
                    'Pemeriksaan Eksternal Kegiatan '.$i,



                'nomor_lhp' =>
                    ($i+10).'/LHP/EKSTERNAL/2026',



                'tanggal_lhp' =>
                    now()->subDays($i+20),



                'nomor_spt' =>
                    ($i+10).'/SPT/EKSTERNAL/2026',



                'tanggal_spt' =>
                    now()->subDays($i+25),



                'tahun_pkpt' =>
                    2026,



                'jumlah_dana_diawasi' =>
                    rand(500000000,1000000000),



                'jenis_pemeriksaan' =>
                    'pkpt',



                'status_lhp' =>
                    $nihil
                        ? 'lengkap'
                        : 'tidak_lengkap',



                'status_proses' =>
                    $nihil
                        ? 'nihil'
                        : 'belum_diproses',



            ]);

        }

    }
}
