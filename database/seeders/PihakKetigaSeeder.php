<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PihakKetiga;

class PihakKetigaSeeder extends Seeder
{
    public function run(): void
    {

        $data = [

            [
                'nama_perusahaan' => 'PT Maju Jaya Konstruksi',
                'nama_pimpinan' => 'Andi Saputra',
                'alamat' => 'Jl. Merdeka No. 10 Ketapang',
                'paket_pekerjaan' => 'Pembangunan Gedung Pemerintah'
            ],


            [
                'nama_perusahaan' => 'CV Borneo Mandiri',
                'nama_pimpinan' => 'Rudi Hartono',
                'alamat' => 'Jl. Diponegoro No. 25 Ketapang',
                'paket_pekerjaan' => 'Pengadaan Barang dan Jasa'
            ],


            [
                'nama_perusahaan' => 'PT Kalimantan Infrastruktur',
                'nama_pimpinan' => 'Dedi Irawan',
                'alamat' => 'Jl. A. Yani Ketapang',
                'paket_pekerjaan' => 'Pembangunan Jalan dan Drainase'
            ],


            [
                'nama_perusahaan' => 'CV Sumber Rezeki',
                'nama_pimpinan' => 'Fajar Kurniawan',
                'alamat' => 'Jl. Rahadi Usman Ketapang',
                'paket_pekerjaan' => 'Pemeliharaan Gedung'
            ],


            [
                'nama_perusahaan' => 'PT Mitra Karya Abadi',
                'nama_pimpinan' => 'Bambang Setiawan',
                'alamat' => 'Jl. Veteran Ketapang',
                'paket_pekerjaan' => 'Pekerjaan Konstruksi Infrastruktur'
            ],


        ];



        foreach ($data as $item) {


            PihakKetiga::create($item);


        }

    }
}
