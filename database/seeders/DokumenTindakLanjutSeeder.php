<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DokumenTindakLanjut;


class DokumenTindakLanjutSeeder extends Seeder
{

    public function run(): void
    {


        DokumenTindakLanjut::create([

            'tindak_lanjut_id' => 1,

            'nama_file' => 'bukti_pengembalian.pdf',

            'path_file' => 'dokumen/tindak-lanjut/bukti_pengembalian.pdf',

            'tipe_file' => 'pdf'

        ]);
    }
}
