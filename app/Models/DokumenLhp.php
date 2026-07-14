<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DokumenLhp extends Model
{
    protected $table = 'dokumen_lhp';

    protected $fillable = [
        'lhp_id',
        'nama_file',
        'path_file',
        'tipe_file'
    ];

    public function lhp()
    {
        return $this->belongsTo(Lhp::class);
    }
}
