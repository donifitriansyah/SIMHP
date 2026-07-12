<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use App\Models\Lhp;

class LaporanController extends Controller
{

    public function index()
    {


        $irbans = Irban::with([

            'lhps.temuans.rekomendasis.tindakLanjut'

        ])->get();



        $laporan = [];



        foreach ($irbans as $irban) {



            $totalLhp = $irban->lhps->count();



            $totalTemuan = 0;

            $totalRekomendasi = 0;


            $selesai = 0;

            $dalamProses = 0;

            $belum = 0;



            $nilaiKerugian = 0;

            $nilaiDisetor = 0;



            $nilaiPajak = 0;

            $nilaiPajakDisetor = 0;




            foreach ($irban->lhps as $lhp) {



                foreach ($lhp->temuans as $temuan) {


                    $totalTemuan++;



                    foreach ($temuan->rekomendasis as $rekomendasi) {



                        $totalRekomendasi++;



                        /*
                         * Kerugian Negara
                         */

                        $nilaiKerugian +=
                            $rekomendasi->nilai_finansial ?? 0;



                        /*
                         * Pajak
                         */

                        $nilaiPajak +=
                            $rekomendasi->nilai_pajak ?? 0;




                        /*
                         * Tindak Lanjut
                         */


                        if ($rekomendasi->tindakLanjut->count() == 0) {


                            $belum++;
                        } else {


                            foreach (
                                $rekomendasi->tindakLanjut
                                as $tl
                            ) {


                                if ($tl->status_id == 3) {


                                    $selesai++;
                                } elseif ($tl->status_id == 2) {


                                    $dalamProses++;
                                } else {


                                    $belum++;
                                }



                                /*
                                 * Pengembalian Kerugian
                                 */

                                $nilaiDisetor +=
                                    $tl->nilai_pengembalian ?? 0;




                                /*
                                 * Setor Pajak
                                 */

                                $nilaiPajakDisetor +=
                                    $tl->nilai_setor_pajak ?? 0;
                            }
                        }
                    }
                }
            }




            /*
             * Persentase TL
             */


            $persenSelesai = $totalRekomendasi > 0

                ? round(
                    ($selesai / $totalRekomendasi) * 100,
                    2
                )

                : 0;




            $persenProses = $totalRekomendasi > 0

                ? round(
                    ($dalamProses / $totalRekomendasi) * 100,
                    2
                )

                : 0;




            $persenBelum = $totalRekomendasi > 0

                ? round(
                    ($belum / $totalRekomendasi) * 100,
                    2
                )

                : 0;




            /*
             * Kerugian
             */


            $sisaKerugian =
                $nilaiKerugian - $nilaiDisetor;



            $persenKerugian = $nilaiKerugian > 0

                ? round(
                    ($nilaiDisetor / $nilaiKerugian) * 100,
                    2
                )

                : 0;




            /*
             * Pajak
             */


            $sisaPajak =
                $nilaiPajak - $nilaiPajakDisetor;



            $persenPajak = $nilaiPajak > 0

                ? round(
                    ($nilaiPajakDisetor / $nilaiPajak) * 100,
                    2
                )

                : 0;




            $laporan[] = [


                'wilayah' => $irban->nama_irban,


                'lhp' => $totalLhp,


                'temuan' => $totalTemuan,


                'rekomendasi' => $totalRekomendasi,



                'selesai' => $selesai,

                'persen_selesai' => $persenSelesai,


                'dalam_proses' => $dalamProses,

                'persen_proses' => $persenProses,


                'belum' => $belum,

                'persen_belum' => $persenBelum,



                'kerugian' => $nilaiKerugian,

                'disetor' => $nilaiDisetor,

                'persen_kerugian' => $persenKerugian,

                'sisa_kerugian' => $sisaKerugian,



                'pajak' => $nilaiPajak,

                'pajak_disetor' => $nilaiPajakDisetor,

                'persen_pajak' => $persenPajak,

                'sisa_pajak' => $sisaPajak,


            ];
        }




        return view(

            'pages.laporan.index',

            compact('laporan')

        );
    }
}
