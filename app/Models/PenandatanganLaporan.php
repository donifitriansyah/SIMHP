<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenandatanganLaporan extends Model
{
    use HasFactory;

    protected $table = 'penandatangan_laporan';

    protected $fillable = [
        'kode',
        'nama',
        'jabatan',
        'golongan',
        'nip',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Scope hanya data aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }

    /**
     * Ambil data Inspektur
     */
    public static function inspektur()
    {
        return self::where('kode', 'inspektur')->first();
    }

    /**
     * Ambil data Sekretaris
     */
    public static function sekretaris()
    {
        return self::where('kode', 'sekretaris')->first();
    }
}
