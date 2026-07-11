<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Auditee extends Model
{

    protected $table='auditee';


    protected $fillable=[
        'nama_dinas',
        'alamat'
    ];


    public function lhps()
    {
        return $this->hasMany(
            Lhp::class
        );
    }


    public function pejabat()
    {
        return $this->hasMany(
            PejabatAuditee::class
        );
    }

}
