<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilInspektorat;


class ProfilInspektoratSeeder extends Seeder
{

    public function run(): void
    {

        ProfilInspektorat::create([

            'nama' => 'Inspektorat Kabupaten Ketapang',

            'alamat' => 'Jl. Jendral Sudirman Ketapang',

            'telepon' => '0562-000000',

            'email' => 'inspektorat@ketapang.go.id'

        ]);
    }
}
