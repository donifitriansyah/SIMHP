<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Irban;


class IrbanSeeder extends Seeder
{

    public function run(): void
    {

        $data = [
            'Inspektur Pembantu I',
            'Inspektur Pembantu II',
            'Inspektur Pembantu III',
            'Inspektur Pembantu IV',
            'Inspektur Pembantu V'
        ];


        foreach ($data as $key => $item) {

            Irban::create([


                'nama_irban' => $item,
                'nama_inspektur_pembantu' => $item,
                'kode' => 'IRBAN-' . ($key + 1),

                'status' => true

            ]);
        }
    }
}
