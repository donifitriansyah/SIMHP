<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use App\Models\Lhp;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\TindakLanjut;

class DashboardController extends Controller
{


    // public function index()
    // {


    //     $totalLhp = Lhp::count();


    //     $totalTemuan = Temuan::count();


    //     $totalRekomendasi = Rekomendasi::count();


    //     $totalTindakLanjut = TindakLanjut::count();



    //     // Status LHP

    //     $lhpLengkap = Lhp::where(
    //         'status_lhp',
    //         'lengkap'
    //     )->count();



    //     $lhpTidakLengkap = Lhp::where(
    //         'status_lhp',
    //         'tidak_lengkap'
    //     )->count();




    //     // Nilai kerugian

    //     $totalKerugian = Rekomendasi::sum(
    //         'nilai_finansial'
    //     );



    //     // Pengembalian

    //     $totalPengembalian = TindakLanjut::sum(
    //         'nilai_pengembalian'
    //     );



    //     // Aktivitas terakhir

    //     $aktivitas = Lhp::latest()
    //         ->limit(5)
    //         ->get();



    //     return view(
    //         'dashboard',
    //         compact(
    //             'totalLhp',
    //             'totalTemuan',
    //             'totalRekomendasi',
    //             'totalTindakLanjut',
    //             'lhpLengkap',
    //             'lhpTidakLengkap',
    //             'totalKerugian',
    //             'totalPengembalian',
    //             'aktivitas'
    //         )
    //     );

    // }

    public function index()
    {

        $totalLhp = Lhp::count();


        $totalTemuan = Temuan::count();


        $totalRekomendasi = Rekomendasi::count();


        $totalTindakLanjut = TindakLanjut::count();



        // Status LHP Lengkap / Tidak Lengkap

        $lhpLengkap = Lhp::where(
            'status_lhp',
            'lengkap'
        )->count();



        $lhpTidakLengkap = Lhp::where(
            'status_lhp',
            'tidak_lengkap'
        )->count();



        // Status Proses LHP untuk Grafik

        $statusLhp = [

            'selesai' => Lhp::where(
                'status_proses',
                'selesai'
            )->count(),


            'dalam_proses' => Lhp::where(
                'status_proses',
                'dalam_proses'
            )->count(),


            'belum_proses' => Lhp::where(
                'status_proses',
                'belum_proses'
            )->count(),


            'nihil' => Lhp::where(
                'status_proses',
                'nihil'
            )->count(),

        ];

        // Nilai kerugian

        $totalKerugian = Rekomendasi::sum(
            'nilai_finansial'
        );

        // Pengembalian

        $totalPengembalian = TindakLanjut::sum(
            'nilai_pengembalian'
        );



        // Aktivitas terakhir

        $aktivitas = Lhp::latest()
            ->limit(5)
            ->get();

        $temuanIrban = Irban::with('lhps.temuans')
            ->get()
            ->map(function ($irban) {

                return [

                    'nama' => $irban->nama_irban,

                    'total' => $irban->lhps
                        ->sum(function ($lhp) {

                            return $lhp->temuans->count();
                        })

                ];
            });

        $dataKerugian = [

            'total' => Rekomendasi::sum(
                'nilai_finansial'
            ),


            'dikembalikan' => TindakLanjut::sum(
                'nilai_pengembalian'
            ),


        ];


        $dataKerugian = [

            'total' => $totalKerugian,

            'dikembalikan' => $totalPengembalian,

            'sisa' => $totalKerugian - $totalPengembalian

        ];

        $aktivitas = collect();



        foreach (Lhp::latest()->limit(5)->get() as $item) {

            $aktivitas->push([

                'judul' => 'LHP Baru',

                'deskripsi' =>
                'LHP ' . $item->nomor_lhp . ' telah ditambahkan',

                'tanggal' => $item->created_at,

                'icon' => 'bi-file-earmark-text'

            ]);
        }



        foreach (Temuan::latest()->limit(5)->get() as $item) {

            $aktivitas->push([

                'judul' => 'Temuan Baru',

                'deskripsi' =>
                'Temuan nomor ' . $item->nomor_temuan .
                    ' pada LHP ' . $item->lhp->nomor_lhp,

                'tanggal' => $item->created_at,

                'icon' => 'bi-search'

            ]);
        }



        foreach (TindakLanjut::latest()->limit(5)->get() as $item) {

            $aktivitas->push([

                'judul' => 'Tindak Lanjut',

                'deskripsi' =>
                'Status tindak lanjut ' .
                    ($item->status->nama_status ?? '-'),

                'tanggal' => $item->created_at,

                'icon' => 'bi-check-circle'

            ]);
        }



        $aktivitas = $aktivitas
            ->sortByDesc('tanggal')
            ->take(8);


        return view(
            'dashboard',
            compact(
                'totalLhp',
                'totalTemuan',
                'totalRekomendasi',
                'totalTindakLanjut',
                'lhpLengkap',
                'lhpTidakLengkap',
                'statusLhp',
                'totalKerugian',
                'totalPengembalian',
                'aktivitas',
                'temuanIrban',
                'dataKerugian',
            )
        );
    }
}
