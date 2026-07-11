<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lhp;


class LhpSeeder extends Seeder
{

    public function run(): void
    {


        Lhp::create([


            'irban_id' => 1,

            'auditee_id' => 1,

            'pihak_ketiga_id' => 1,

            'objek_pemeriksaan_id' => 1,


            'nomor_lhp' => '700/LHP/001/2026',


            'tanggal_lhp' => '2026-01-15',


            'nomor_spt' => '090/SPT/001',


            'tanggal_spt' => '2026-01-01',


            'tahun_pkpt' => 2026,


            'jumlah_dana_diawasi' => 500000000,


            'jenis_pemeriksaan' => 'PKPT',


            'status_lhp' => 'lengkap'


        ]);
    }
}
