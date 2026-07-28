<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PihakLain extends Model
{
    protected $table = 'pihak_lain';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function detailTemuanFinansial()
    {
        return $this->hasMany(
            DetailTemuanFinansial::class,
            'pihak_lain_id'
        );
    }
}
