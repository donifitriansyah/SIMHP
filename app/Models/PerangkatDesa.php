<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    protected $table = 'perangkat_desa';

    protected $fillable = [
        'nama',
        'jabatan',
        'desa',
        'kecamatan',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function detailTemuanFinansial()
    {
        return $this->hasMany(
            DetailTemuanFinansial::class,
            'perangkat_desa_id'
        );
    }
}
