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
        'pejabat_auditee_id',
        'pihak_ketiga_id',
        'objek_pemeriksaan',
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
        // Jika nihil langsung lengkap
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


        foreach ($this->temuans as $temuan) {


            // Temuan wajib memiliki rekomendasi
            if ($temuan->rekomendasis()->count() == 0) {

                $this->update([
                    'status_lhp' => 'tidak_lengkap'
                ]);

                return;
            }



            foreach ($temuan->rekomendasis as $rekomendasi) {


                $tindakLanjutSelesai = $rekomendasi->tindakLanjut()
                    ->whereHas('status', function ($query) {
                        $query->where('kode', 'S');
                    })
                    ->count();



                if ($tindakLanjutSelesai == 0) {

                    $this->update([
                        'status_lhp' => 'tidak_lengkap'
                    ]);

                    return;
                }
            }
        }


        $this->update([
            'status_lhp' => 'lengkap'
        ]);
    }

    public function updateStatusProses()
    {
        if ($this->status_proses === 'nihil') {
            return;
        }


        $this->loadMissing(
            'temuans.rekomendasis'
        );


        $totalTemuan = $this->temuans->count();

        $totalRekomendasi = 0;

        $totalRekomendasiSelesai = 0;



        foreach ($this->temuans as $temuan) {


            foreach ($temuan->rekomendasis as $rekomendasi) {


                $totalRekomendasi++;



                $tindakLanjutTerakhir = $rekomendasi
                    ->tindakLanjut()
                    ->with('status')
                    ->orderBy('id', 'desc')
                    ->first();



                if (
                    $tindakLanjutTerakhir &&
                    $tindakLanjutTerakhir->status &&
                    $tindakLanjutTerakhir->status->kode === 'S'
                ) {

                    $totalRekomendasiSelesai++;
                }
            }
        }



        if ($totalTemuan == 0) {

            $status = 'belum_diproses';
        } elseif ($totalRekomendasi == 0) {

            $status = 'dalam_proses';
        } elseif ($totalRekomendasi == $totalRekomendasiSelesai) {

            $status = 'selesai';
        } else {

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
