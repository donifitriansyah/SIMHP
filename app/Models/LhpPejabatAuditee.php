<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LhpPejabatAuditee extends Model
{

    protected $table = 'lhp_pejabat_auditee';


    protected $fillable = [
        'lhp_id',
        'pejabat_auditee_id'
    ];


    public function pejabatAuditee()
    {
        return $this->belongsTo(
            PejabatAuditee::class,
            'pejabat_auditee_id'
        );
    }


    public function lhp()
    {
        return $this->belongsTo(
            Lhp::class,
            'lhp_id'
        );
    }
}
