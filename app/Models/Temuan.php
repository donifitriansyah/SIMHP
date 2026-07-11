<?php

namespace App\Models;

use App\Models\Rekomendasi;
use Illuminate\Database\Eloquent\Model;


class Temuan extends Model
{

    protected $table='temuan';


    protected $fillable=[

        'lhp_id',
        'nomor_temuan',
        'uraian_temuan',
        'administrasi',
        'nilai_kerugian',
        'nama_pelaku'

    ];



    public function lhp()
    {
        return $this->belongsTo(
            Lhp::class
        );
    }



    public function rekomendasi()
    {
        return $this->hasMany(
            Rekomendasi::class
        );
    }

}
