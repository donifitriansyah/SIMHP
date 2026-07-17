<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use Illuminate\Http\Request;

class MatriksTindakLanjutController extends Controller
{
    public function index(Request $request)
    {
        $lhps = Lhp::with([
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status',
            'temuans.rekomendasis.tindakLanjut.dokumen'
        ])

            ->when($request->jenis == 'internal', function ($query) {

                $query->where(
                    'instansi_pemeriksa',
                    'Itkab'
                );
            })

            ->when($request->jenis == 'eksternal', function ($query) {

                $query->whereIn(
                    'instansi_pemeriksa',
                    [
                        'Itprov',
                        'BPK RI',
                        'BPKP'
                    ]
                );
            })

            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {

                $query->whereDate(
                    'tanggal_lhp',
                    '>=',
                    $request->tanggal_awal
                );
            })

            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {

                $query->whereDate(
                    'tanggal_lhp',
                    '<=',
                    $request->tanggal_akhir
                );
            })

            ->latest()
            ->get();

        $matriks = [];

        foreach ($lhps as $lhp) {

            /*
        |--------------------------------------------------------------------------
        | Jangan tampilkan LHP Nihil
        |--------------------------------------------------------------------------
        */

            if (strtolower($lhp->status_lhp) == 'nihil') {
                continue;
            }

            $jumlahTemuan = $lhp->temuans->count();

            $jumlahRekomendasi = 0;

            $selesai = 0;
            $proses = 0;
            $belum = 0;

            $pengembalian = 0;
            $setorPajak = 0;

            $jenisTL = '-';

            $adaDokumen = false;

            /*
        |--------------------------------------------------------------------------
        | Penanda apakah ada tindak lanjut
        |--------------------------------------------------------------------------
        */

            $adaTindakLanjut = false;

            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $jumlahRekomendasi++;

                    $tl = $rekomendasi->tindakLanjut
                        ->sortByDesc('created_at')
                        ->first();

                    if (!$tl) {
                        continue;
                    }

                    $adaTindakLanjut = true;

                    $jenisTL = $tl->jenis_tindak_lanjut ?? '-';

                    switch ($tl->status_id) {

                        case 3:
                            $selesai++;
                            break;

                        case 2:
                            $proses++;
                            break;

                        default:
                            $belum++;
                            break;
                    }

                    $pengembalian += $tl->nilai_pengembalian ?? 0;

                    $setorPajak += $tl->nilai_setor_pajak ?? 0;

                    if ($tl->dokumen->count() > 0) {
                        $adaDokumen = true;
                    }
                }
            }

            /*
        |--------------------------------------------------------------------------
        | Jika tidak ada tindak lanjut sama sekali jangan tampilkan
        |--------------------------------------------------------------------------
        */

            if (!$adaTindakLanjut) {
                continue;
            }

            /*
        |--------------------------------------------------------------------------
        | Status LHP
        |--------------------------------------------------------------------------
        */

            if ($selesai == $jumlahRekomendasi) {

                $status = 'Selesai';
            } elseif ($proses > 0 || $selesai > 0) {

                $status = 'Dalam Proses';
            } else {

                $status = 'Belum Ditindaklanjuti';
            }

            $matriks[] = [

                'nomor_lhp' => $lhp->nomor_lhp,

                'tanggal' => $lhp->tanggal_lhp,

                'auditee' => $lhp->auditee->nama_dinas ?? '-',

                'nama_pejabat_eksternal' => $lhp->nama_pejabat_eksternal,

                'temuan' => $jumlahTemuan,

                'rekomendasi' => $jumlahRekomendasi,

                'jenis_tindak_lanjut' => $jenisTL,

                'status' => $status,

                'selesai' => $selesai,

                'proses' => $proses,

                'belum' => $belum,

                'pengembalian' => $pengembalian,

                'pajak' => $setorPajak,

                'dokumen' => $adaDokumen,
            ];
        }

        return view(
            'pages.laporan.matriks',
            compact('matriks')
        );
    }
}
