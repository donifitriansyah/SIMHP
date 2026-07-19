<?php

namespace App\Models;

use App\Models\Temuan;
use Illuminate\Database\Eloquent\Model;


class DetailTemuanFinansial extends Model
{

    protected $table='detail_temuan_finansial';


    protected $fillable=[
        'temuan_id',
        'jenis',
        'nama_pihak',
        'nama_penyedia',
        'nilai_temuan'
    ];



    public function temuan()
    {
        return $this->belongsTo(
            Temuan::class
        );
    }

}
