<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'internal';


        /*
    |--------------------------------------------------------------------------
    | Filter LHP Internal / Eksternal
    |--------------------------------------------------------------------------
    */

        $lhpQuery = Lhp::query();


        if ($jenis == 'internal') {

            $lhpQuery->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        } else {

            $lhpQuery->whereIn(
                'instansi_pemeriksa',
                [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]
            );
        }



        /*
    |--------------------------------------------------------------------------
    | Statistik Utama
    |--------------------------------------------------------------------------
    */


        $totalLhp = (clone $lhpQuery)->count();



        $totalTemuan = Temuan::whereHas(
            'lhp',
            function ($q) use ($jenis) {

                if ($jenis == 'internal') {

                    $q->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } else {

                    $q->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
            }
        )->count();



        $totalRekomendasi = Rekomendasi::whereHas(
            'temuan.lhp',
            function ($q) use ($jenis) {

                if ($jenis == 'internal') {

                    $q->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } else {

                    $q->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
            }
        )->count();



        $totalTindakLanjut = TindakLanjut::whereHas(
            'rekomendasi.temuan.lhp',
            function ($q) use ($jenis) {

                if ($jenis == 'internal') {

                    $q->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } else {

                    $q->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
            }
        )->count();





        /*
    |--------------------------------------------------------------------------
    | Status LHP
    |--------------------------------------------------------------------------
    */


        $lhpLengkap = (clone $lhpQuery)
            ->where(
                'status_lhp',
                'lengkap'
            )
            ->count();



        $lhpTidakLengkap = (clone $lhpQuery)
            ->where(
                'status_lhp',
                'tidak_lengkap'
            )
            ->count();





        /*
    |--------------------------------------------------------------------------
    | Grafik Status LHP
    |--------------------------------------------------------------------------
    */


        $statusLhp = [

            'selesai' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'selesai'
                )
                ->count(),


            'dalam_proses' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'dalam_proses'
                )
                ->count(),


            'belum_proses' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'belum_diproses'
                )
                ->count(),


            'nihil' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'nihil'
                )
                ->count(),

        ];





        /*
    |--------------------------------------------------------------------------
    | Nilai Kerugian
    |--------------------------------------------------------------------------
    */


        $totalKerugian = Rekomendasi::whereHas(
            'temuan.lhp',
            function ($q) use ($jenis) {


                if ($jenis == 'internal') {

                    $q->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } else {

                    $q->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
            }
        )->sum('nilai_finansial');





        /*
    |--------------------------------------------------------------------------
    | Pengembalian
    |--------------------------------------------------------------------------
    */


        $totalPengembalian = TindakLanjut::whereHas(
            'rekomendasi.temuan.lhp',
            function ($q) use ($jenis) {


                if ($jenis == 'internal') {

                    $q->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } else {

                    $q->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
            }
        )->sum('nilai_pengembalian');





        /*
    |--------------------------------------------------------------------------
    | Temuan Per Irban
    |--------------------------------------------------------------------------
    */


        $temuanIrban = Irban::with([
            'lhps.temuans'
        ])
            ->get()
            ->map(function ($irban) use ($jenis) {


                $total = $irban->lhps
                    ->filter(function ($lhp) use ($jenis) {


                        if ($jenis == 'internal') {

                            return $lhp->instansi_pemeriksa == 'Itkab';
                        }


                        return in_array(
                            $lhp->instansi_pemeriksa,
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    })
                    ->sum(function ($lhp) {


                        return $lhp->temuans->count();
                    });



                return [

                    'nama' => $irban->nama_irban,

                    'total' => $total

                ];
            });





        /*
    |--------------------------------------------------------------------------
    | Aktivitas Terbaru
    |--------------------------------------------------------------------------
    */


        $aktivitas = collect();



        Lhp::whereIn(
            'id',
            (clone $lhpQuery)
                ->latest()
                ->limit(5)
                ->pluck('id')
        )
            ->latest()
            ->get()
            ->each(function ($item) use ($aktivitas) {


                $aktivitas->push([

                    'judul' => 'LHP Baru',

                    'deskripsi' =>
                    'LHP ' . $item->nomor_lhp . ' telah ditambahkan',

                    'tanggal' => $item->created_at,

                    'icon' => 'bi-file-earmark-text'

                ]);
            });





        $aktivitas = $aktivitas
            ->sortByDesc('tanggal')
            ->take(8);





        /*
    |--------------------------------------------------------------------------
    | Data Kerugian Grafik
    |--------------------------------------------------------------------------
    */


        $dataKerugian = [

            'total' => $totalKerugian,

            'dikembalikan' => $totalPengembalian,

            'sisa' =>
            $totalKerugian - $totalPengembalian

        ];





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
                'jenis'
            )
        );
    }
}
