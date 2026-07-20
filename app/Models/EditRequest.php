<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditRequest extends Model
{
    protected $fillable = [
        'user_id',
        'lhp_id',
        'alasan',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function lhp()
    {
        return $this->belongsTo(Lhp::class);
    }

    public function canEditLhp(Lhp $lhp): bool
    {
        if ($this->isSuperUser()) {

            return true;
        }


        if ($this->isUserView()) {

            return false;
        }


        return EditRequest::where('lhp_id', $lhp->id)
            ->where('user_id', $this->id)
            ->where('status', 'approved')
            ->exists();
    }
}
