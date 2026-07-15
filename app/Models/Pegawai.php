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
        'irban_id'
    ];

    public function irban()
    {
        return $this->belongsTo(Irban::class);
    }
}
