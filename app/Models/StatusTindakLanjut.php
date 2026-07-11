<?php

namespace App\Models;

use App\Models\TindakLanjut;
use Illuminate\Database\Eloquent\Model;


class StatusTindakLanjut extends Model
{

    protected $table='status_tindak_lanjut';


    protected $fillable=[

        'kode',
        'nama_status'

    ];



    public function tindakLanjut()
    {
        return $this->hasMany(
            TindakLanjut::class,
            'status_id'
        );
    }

}
