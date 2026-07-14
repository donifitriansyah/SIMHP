<?php

namespace App\Models;

use App\Models\Temuan;
use Illuminate\Database\Eloquent\Model;


class Lhp extends Model
{

    protected $table = 'lhp';


    protected $fillable = [

        'irban_id',
        'auditee_id',
        'pejabat_auditee_id',
        'pihak_ketiga_id',
        'objek_pemeriksaan',
        'nomor_lhp',
        'tanggal_lhp',
        'nomor_spt',
        'tanggal_spt',
        'tahun_pkpt',
        'jumlah_dana_diawasi',
        'jenis_pemeriksaan',
        'status_lhp',
        'status_proses'

    ];

    public function pejabatAuditee()
    {
        return $this->belongsTo(
            PejabatAuditee::class,
            'pejabat_auditee_id'
        );
    }

    public function irban()
    {
        return $this->belongsTo(
            Irban::class
        );
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenLhp::class);
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




    public function temuans()
    {
        return $this->hasMany(
            Temuan::class
        );
    }



    public function updateStatusLhp()
    {
        if ($this->status_proses == 'nihil') {
            $this->update([
                'status_lhp' => 'lengkap'
            ]);
            return;
        }

        // Belum ada temuan
        if ($this->temuans()->count() == 0) {
            $this->update([
                'status_lhp' => 'tidak_lengkap'
            ]);
            return;
        }

        // Semua temuan wajib memiliki rekomendasi
        foreach ($this->temuans as $temuan) {
            if ($temuan->rekomendasis()->count() == 0) {
                $this->update([
                    'status_lhp' => 'tidak_lengkap'
                ]);
                return;
            }
        }

        // Semua sudah punya rekomendasi
        $this->update([
            'status_lhp' => 'lengkap'
        ]);
    }

    public function updateStatusProses()
    {
        if ($this->status_proses == 'nihil') {
            return;
        }

        $totalRekomendasi = 0;
        $totalSelesai = 0;

        $this->loadMissing('temuans.rekomendasis.tindakLanjut.status');

        foreach ($this->temuans as $temuan) {

            foreach ($temuan->rekomendasis as $rekomendasi) {

                $totalRekomendasi++;

                // Ambil tindak lanjut terakhir
                $terakhir = $rekomendasi->tindakLanjut
                    ->sortByDesc('created_at')
                    ->first();

                if (
                    $terakhir &&
                    $terakhir->status &&
                    $terakhir->status->kode == 'S'
                ) {
                    $totalSelesai++;
                }
            }
        }

        if ($totalRekomendasi == 0) {

            $status = 'belum_diproses';
        } elseif ($totalSelesai == $totalRekomendasi) {

            $status = 'selesai';
        } else {

            $status = 'dalam_proses';
        }

        $this->update([
            'status_proses' => $status
        ]);
    }
}
