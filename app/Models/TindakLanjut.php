<?php

namespace App\Models;

use App\Models\DokumenTindakLanjut;
use Illuminate\Database\Eloquent\Model;


class TindakLanjut extends Model
{

    protected $table='tindak_lanjut';


    protected $fillable=[

        'rekomendasi_id',
        'status_id',
        'narasi',
        'nilai_pengembalian',
        'nilai_setor_pajak',
        'tanggal_validasi',
        'validator'

    ];



    public function rekomendasi()
    {
        return $this->belongsTo(
            Rekomendasi::class
        );
    }



    public function status()
    {
        return $this->belongsTo(
            StatusTindakLanjut::class,
            'status_id'
        );
    }



    public function dokumen()
    {
        return $this->hasMany(
            DokumenTindakLanjut::class
        );
    }

}
