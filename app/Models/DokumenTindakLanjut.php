<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DokumenTindakLanjut extends Model
{

    protected $table='dokumen_tindak_lanjut';


    protected $fillable=[

        'tindak_lanjut_id',
        'nama_file',
        'path_file',
        'tipe_file'

    ];



    public function tindakLanjut()
    {
        return $this->belongsTo(
            TindakLanjut::class
        );
    }

}
