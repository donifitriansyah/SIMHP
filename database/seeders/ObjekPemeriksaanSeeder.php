<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObjekPemeriksaan;


class ObjekPemeriksaanSeeder extends Seeder
{

    public function run(): void
    {


        foreach (
            [

                'Pembangunan Jalan',
                'Gedung Pemerintah',
                'Pengadaan Barang',
                'Keuangan',
                'Aset Daerah'

            ] as $item
        ) {

            ObjekPemeriksaan::create([

                'nama_objek' => $item

            ]);
        }
    }
}
