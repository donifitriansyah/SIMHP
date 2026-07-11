<?php

namespace App\Models;

use App\Models\Lhp;
use Illuminate\Database\Eloquent\Model;


class ObjekPemeriksaan extends Model
{

    protected $table='objek_pemeriksaan';


    protected $fillable=[

        'nama_objek'

    ];



    public function lhps()
    {
        return $this->hasMany(
            Lhp::class
        );
    }

}
