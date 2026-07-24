<?php

namespace App\Models;

use App\Models\Temuan;
use Illuminate\Database\Eloquent\Model;


class DetailTemuanFinansial extends Model
{

    protected $table = 'detail_temuan_finansial';


    protected $fillable = [

        'temuan_id',

        'jenis',

        'pegawai_id',

        'pihak_ketiga_id',

        'nilai_temuan',

    ];



    public function temuan()
    {
        return $this->belongsTo(
            Temuan::class
        );
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function pihakKetiga()
    {
        return $this->belongsTo(PihakKetiga::class);
    }
}
