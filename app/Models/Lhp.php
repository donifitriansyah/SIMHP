<?php

namespace App\Models;

use App\Models\Temuan;
use Illuminate\Database\Eloquent\Model;


class Lhp extends Model
{

    protected $table='lhp';


    protected $fillable=[

        'irban_id',
        'auditee_id',
        'pihak_ketiga_id',
        'objek_pemeriksaan_id',
        'nomor_lhp',
        'tanggal_lhp',
        'nomor_spt',
        'tanggal_spt',
        'tahun_pkpt',
        'jumlah_dana_diawasi',
        'jenis_pemeriksaan',
        'status_lhp'

    ];



    public function irban()
    {
        return $this->belongsTo(
            Irban::class
        );
    }



    public function auditee()
    {
        return $this->belongsTo(
            Auditee::class
        );
    }



    public function pihakKetiga()
    {
        return $this->belongsTo(
            PihakKetiga::class
        );
    }



    public function objekPemeriksaan()
    {
        return $this->belongsTo(
            ObjekPemeriksaan::class
        );
    }



    public function temuans()
    {
        return $this->hasMany(
            Temuan::class
        );
    }

}
