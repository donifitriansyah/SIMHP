<?php

namespace App\Models;

use App\Models\Temuan;
use Illuminate\Database\Eloquent\Model;


class Lhp extends Model
{

    protected $table = 'lhp';

    public const INSTANSI_ITKAB = 'Itkab';
    public const INSTANSI_ITPROV = 'Itprov';
    public const INSTANSI_BPK_RI = 'BPK RI';
    public const INSTANSI_BPKP = 'BPKP';

    protected $fillable = [

        'irban_id',
        'auditee_id',
        'nama_pejabat_eksternal',
        'nomor_lhp',
        'tanggal_lhp',
        'nomor_spt',
        'tanggal_spt',
        'tahun_pkpt',
        'jumlah_dana_diawasi',
        'jenis_pemeriksaan',
        'instansi_pemeriksa',
        'status_lhp',
        'status_proses'

    ];

    public function getStatusProsesLabelAttribute()
    {
        return match ($this->status_proses) {

            'tt' => 'TT (Tidak Dapat Ditindaklanjuti)',

            'belum_diproses' => 'Belum Diproses',

            'dalam_proses' => 'Dalam Proses',

            'selesai' => 'Selesai',

            default => '-',
        };
    }

    public static function getInstansiPemeriksa(): array
    {
        return [
            self::INSTANSI_ITKAB => 'Inspektorat Kabupaten',
            self::INSTANSI_ITPROV => 'Inspektorat Provinsi',
            self::INSTANSI_BPK_RI => 'Badan Pemeriksa Keuangan Republik Indonesia',
            self::INSTANSI_BPKP => 'Badan Pengawasan Keuangan dan Pembangunan',
        ];
    }

    public function getInstansiPemeriksaLabelAttribute()
    {
        return match ($this->instansi_pemeriksa) {
            'Itkab' => 'Inspektorat Kabupaten',
            'Itprov' => 'Inspektorat Provinsi',
            'BPK RI' => 'Badan Pemeriksa Keuangan Republik Indonesia',
            'BPKP' => 'Badan Pengawasan Keuangan dan Pembangunan',
            default => $this->instansi_pemeriksa,
        };
    }

    public function pejabatAuditees()
    {
        return $this->hasMany(
            LhpPejabatAuditee::class,
            'lhp_id'
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

    public function objekPemeriksaans()
    {
        return $this->hasMany(
            LhpObjekPemeriksaan::class
        );
    }

    public function pihakKetigas()
    {
        return $this->belongsToMany(
            PihakKetiga::class,
            'lhp_pihak_ketiga'
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
        // Tidak Dapat Ditindaklanjuti dianggap selesai/lengkap
        if ($this->status_proses == 'tt') {

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



        // Cek setiap temuan
        foreach ($this->temuans as $temuan) {


            // Setiap temuan wajib memiliki rekomendasi
            if ($temuan->rekomendasis()->count() == 0) {

                $this->update([
                    'status_lhp' => 'tidak_lengkap'
                ]);

                return;
            }



            // Cek setiap rekomendasi
            foreach ($temuan->rekomendasis as $rekomendasi) {


                $tindakLanjutSelesai = $rekomendasi
                    ->tindakLanjut()
                    ->whereHas('status', function ($query) {

                        $query->where('kode', 'S');
                    })
                    ->exists();



                // Jika rekomendasi belum selesai
                if (!$tindakLanjutSelesai) {

                    $this->update([
                        'status_lhp' => 'tidak_lengkap'
                    ]);

                    return;
                }
            }
        }



        // Semua temuan punya rekomendasi
        // Semua rekomendasi selesai
        $this->update([
            'status_lhp' => 'lengkap'
        ]);
    }

    public function updateStatusProses()
    {
        // TT ditentukan manual oleh admin
        if ($this->status_proses == 'tt') {
            return;
        }

        $this->loadMissing([
            'temuans.rekomendasis.tindakLanjut.status'
        ]);

        $totalRekomendasi = 0;
        $rekomendasiAdaTL = 0;
        $rekomendasiSelesai = 0;

        foreach ($this->temuans as $temuan) {

            foreach ($temuan->rekomendasis as $rekomendasi) {

                $totalRekomendasi++;

                $tlTerakhir = $rekomendasi->tindakLanjut
                    ->sortByDesc('id')
                    ->first();

                // Sudah pernah ditindaklanjuti
                if ($tlTerakhir) {

                    $rekomendasiAdaTL++;

                    // Sudah selesai
                    if (
                        $tlTerakhir->status &&
                        $tlTerakhir->status->kode == 'S'
                    ) {
                        $rekomendasiSelesai++;
                    }
                }
            }
        }

        // Tidak ada rekomendasi
        if ($totalRekomendasi == 0) {

            $status = 'belum_ditindaklanjuti';
        }
        // Belum ada satupun TL
        elseif ($rekomendasiAdaTL == 0) {

            $status = 'belum_ditindaklanjuti';
        }
        // Semua rekomendasi selesai
        elseif ($rekomendasiSelesai == $totalRekomendasi) {

            $status = 'selesai';
        }
        // Sudah ada TL tetapi belum semuanya selesai
        else {

            $status = 'dalam_proses';
        }

        $this->update([
            'status_proses' => $status
        ]);
    }

    public function editRequests()
    {
        return $this->hasMany(EditRequest::class);
    }
}
