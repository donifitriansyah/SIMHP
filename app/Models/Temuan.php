<?php

namespace App\Models;

use App\Models\Rekomendasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Temuan extends Model
{

    protected $table = 'temuan';


    protected $fillable = [

        'lhp_id',
        'nomor_temuan',
        'uraian_temuan',
        'administrasi',
        'nilai_kerugian',
        'nama_pelaku'

    ];

    public function detailFinansial()
    {
        return $this->hasMany(
            DetailTemuanFinansial::class
        );
    }


    public function lhp()
    {
        return $this->belongsTo(
            Lhp::class
        );
    }





    public function rekomendasis()
    {
        return $this->hasMany(
            Rekomendasi::class
        );
    }
}
