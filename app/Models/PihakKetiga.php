<?php

namespace App\Models;

use App\Models\Lhp;
use Illuminate\Database\Eloquent\Model;


class PihakKetiga extends Model
{

    protected $table='pihak_ketiga';


    protected $fillable=[

        'nama_perusahaan',
        'nama_pimpinan',
        'alamat',
        'paket_pekerjaan'

    ];



    public function lhps()
    {
        return $this->hasMany(
            Lhp::class
        );
    }

}
