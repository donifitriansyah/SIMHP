<?php

namespace App\Models;

use App\Models\Auditee;
use Illuminate\Database\Eloquent\Model;


class PejabatAuditee extends Model
{

    protected $table='pejabat_auditee';


    protected $fillable=[

        'auditee_id',
        'jenis_jabatan',
        'nama',
        'tahun'

    ];


    public function auditee()
    {
        return $this->belongsTo(
            Auditee::class
        );
    }

}
