<?php

namespace App\Models;

use App\Models\Lhp;
use Illuminate\Database\Eloquent\Model;


class Irban extends Model
{

    protected $table = 'irban';


    protected $fillable = [

        'nama_irban',
        'kode',
        'status'

    ];


    public function lhps()
    {
        return $this->hasMany(
            Lhp::class
        );
    }

}
