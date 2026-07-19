<?php

namespace App\Models;

use App\Models\DetailRekomendasiFinansial;
use App\Models\TindakLanjut;
use Illuminate\Database\Eloquent\Model;


class Rekomendasi extends Model
{

    protected $table = 'rekomendasi';


    protected $fillable = [

        'temuan_id',
        'uraian_rekomendasi',
        'administrasi',
        'nilai_finansial',
        'nilai_pajak'

    ];



    public function temuan()
    {
        return $this->belongsTo(
            Temuan::class
        );
    }



    public function tindakLanjut()
    {
        return $this->hasMany(
            TindakLanjut::class
        );
    }
}
