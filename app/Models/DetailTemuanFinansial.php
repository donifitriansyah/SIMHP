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

        'perangkat_desa_id',

        'pihak_ketiga_id',

        'pihak_lain_id',

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

    public function perangkatDesa()
    {
        return $this->belongsTo(
            PerangkatDesa::class,
            'perangkat_desa_id'
        );
    }

    public function pihakLain()
    {
        return $this->belongsTo(
            PihakLain::class,
            'pihak_lain_id'
        );
    }

    public function getJenisLabelAttribute()
    {
        return match ($this->jenis) {
            'pns' => 'PNS',
            'perangkat_desa' => 'Perangkat Desa',
            'penyedia' => 'Penyedia',
            'pihak_lain' => 'Pihak Lain',
            default => '-',
        };
    }

    public function getNamaPihakAttribute()
    {
        return match ($this->jenis) {
            'pns' => optional($this->pegawai)->nama,
            'perangkat_desa' => optional($this->perangkatDesa)->nama,
            'penyedia' => optional($this->pihakKetiga)->nama_perusahaan,
            'pihak_lain' => optional($this->pihakLain)->nama,
            default => '-',
        };
    }
}
