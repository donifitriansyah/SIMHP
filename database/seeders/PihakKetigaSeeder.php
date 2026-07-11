<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PihakKetiga;


class PihakKetigaSeeder extends Seeder
{

    public function run(): void
    {

        PihakKetiga::create([

            'nama_perusahaan' => 'PT Maju Konstruksi',

            'nama_pimpinan' => 'Andi Wijaya',

            'alamat' => 'Pontianak',

            'paket_pekerjaan' => 'Pembangunan Jalan Kabupaten'

        ]);
    }
}
