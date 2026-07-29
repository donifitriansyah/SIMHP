<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LhpObjekPemeriksaan extends Model
{

    protected $fillable = [
        'lhp_id',
        'nama_objek'
    ];


    public function lhp()
    {
        return $this->belongsTo(Lhp::class);
    }

}
