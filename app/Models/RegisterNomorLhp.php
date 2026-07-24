<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisterNomorLhp extends Model
{
    use HasFactory;

    protected $table = 'register_nomor_lhp';


    protected $fillable = [

        'irban_id',

        'jenis_dokumen',

        'nomor_dokumen',

        'nomor_spt',

        'tanggal_spt',

        'tahun_pemeriksaan',

        'anggaran_pemeriksaan',

        'objek_pemeriksaan',

        'dana_diawasi',

        'nama_pimpinan',

        'temuan',

    ];


    /**
     * Relasi Tim Pemeriksa / Irban
     */
    public function irban()
    {
        return $this->belongsTo(
            Irban::class,
            'irban_id'
        );
    }


    /**
     * Daftar Jenis Dokumen
     */
    public static function jenisDokumen()
    {
        return [
            'LHP',
            'LHR',
            'LHE',
            'LHM',
            'LHK',
            'LHA',
        ];
    }


    /**
     * Format Anggaran Pemeriksaan
     */
    public function getAnggaranPemeriksaanFormatAttribute()
    {
        return number_format(
            $this->anggaran_pemeriksaan ?? 0,
            0,
            ',',
            '.'
        );
    }


    /**
     * Format Dana Diawasi
     */
    public function getDanaDiawasiFormatAttribute()
    {
        return number_format(
            $this->dana_diawasi ?? 0,
            0,
            ',',
            '.'
        );
    }
}
