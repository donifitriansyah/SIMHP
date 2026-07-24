<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    protected $table = 'skpd';

    protected $fillable = [
        'nama_skpd',
        'wilayah_pengawasan',
        'status',
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
}
