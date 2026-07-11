<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Temuan;


class TemuanSeeder extends Seeder
{

    public function run(): void
    {


        Temuan::create([

            'lhp_id' => 1,

            'nomor_temuan' => '1',

            'uraian_temuan' => 'Pekerjaan jalan mengalami kekurangan volume',

            'administrasi' => 'Dokumen pekerjaan belum lengkap',

            'nilai_kerugian' => 50000000,

            'nama_pelaku' => 'Kontraktor Pelaksana'


        ]);
    }
}
