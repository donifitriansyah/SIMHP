<?php

namespace App\Models;

use App\Models\Irban;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawais';
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'golongan',
        'skpd_id',
    ];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
}
