<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use Illuminate\Http\Request;

class MatriksTindakLanjutController extends Controller
{
    public function index()
    {

        $lhps = Lhp::with([
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status',
            'temuans.rekomendasis.tindakLanjut.dokumen'
        ])
        ->latest()
        ->get();


        $matriks = [];


        foreach($lhps as $lhp)
        {

            foreach($lhp->temuans as $temuan)
            {

                foreach($temuan->rekomendasis as $rekomendasi)
                {


                    $tindakLanjutTerakhir = $rekomendasi
                        ->tindakLanjut
                        ->sortByDesc('created_at')
                        ->first();



                    $matriks[] = [

                        'nomor_lhp' =>
                            $lhp->nomor_lhp,


                        'tanggal' =>
                            $lhp->tanggal_lhp,


                        'auditee' =>
                            $lhp->auditee->nama_dinas ?? '-',


                        'temuan' =>
                            $temuan->uraian_temuan,


                        'rekomendasi' =>
                            $rekomendasi->uraian_rekomendasi,


                        'nilai_finansial' =>
                            $rekomendasi->nilai_finansial,


                        'status' =>
                            $tindakLanjutTerakhir?->status?->nama_status ?? 'Belum Ada',


                        'narasi' =>
                            $tindakLanjutTerakhir?->narasi,


                        'pengembalian' =>
                            $tindakLanjutTerakhir?->nilai_pengembalian ?? 0,


                        'pajak' =>
                            $tindakLanjutTerakhir?->nilai_setor_pajak ?? 0,


                        'dokumen' =>
                            $tindakLanjutTerakhir?->dokumen

                    ];

                }

            }

        }


        return view(
            'pages.laporan.matriks',
            compact('matriks')
        );

    }
}
