<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use App\Models\Lhp;
use App\Models\Pegawai;
use App\Models\PejabatAuditee;
use App\Models\PihakKetiga;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetakPihakKetigaTemuan(Request $request)
    {
        $pihakKetiga = PihakKetiga::with([
            'lhps' => function ($query) use ($request) {

                // Filter tanggal LHP
                if ($request->filled('tanggal_awal')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '>=',
                        $request->tanggal_awal
                    );
                }


                if ($request->filled('tanggal_akhir')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '<=',
                        $request->tanggal_akhir
                    );
                }


                // Filter jenis pemeriksaan
                if ($request->filled('jenis')) {

                    if ($request->jenis == 'internal') {

                        $query->where(
                            'instansi_pemeriksa',
                            'Itkab'
                        );
                    } elseif ($request->jenis == 'eksternal') {

                        $query->whereIn(
                            'instansi_pemeriksa',
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    }
                }


                $query->with([
                    'temuans.rekomendasis'
                ]);
            }

        ])
            ->whereHas('lhps', function ($query) use ($request) {


                $query->whereHas('temuans');


                // Filter tanggal
                if ($request->filled('tanggal_awal')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '>=',
                        $request->tanggal_awal
                    );
                }


                if ($request->filled('tanggal_akhir')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '<=',
                        $request->tanggal_akhir
                    );
                }


                // Filter jenis
                if ($request->filled('jenis')) {

                    if ($request->jenis == 'internal') {

                        $query->where(
                            'instansi_pemeriksa',
                            'Itkab'
                        );
                    } elseif ($request->jenis == 'eksternal') {

                        $query->whereIn(
                            'instansi_pemeriksa',
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    }
                }
            })
            ->get();



        $inspektur = Pegawai::where(
            'jabatan',
            'Inspektur Kabupaten Ketapang'
        )->first();



        $sekretaris = Pegawai::where(
            'jabatan',
            'Sekretaris'
        )->first();



        return view(
            'pages.laporan.cetak-pihak-ketiga-temuan',
            compact(
                'pihakKetiga',
                'inspektur',
                'sekretaris'
            )
        );
    }
    public function pihakKetigaTemuan(Request $request)
    {

        $pihakKetiga = PihakKetiga::with([
            'lhps' => function ($query) use ($request) {


                // Filter Jenis Pemeriksaan
                if ($request->filled('jenis')) {


                    if ($request->jenis == 'internal') {

                        $query->where(
                            'instansi_pemeriksa',
                            'Itkab'
                        );
                    } elseif ($request->jenis == 'eksternal') {

                        $query->whereIn(
                            'instansi_pemeriksa',
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    }
                }


                // Filter tanggal awal
                if ($request->filled('tanggal_awal')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '>=',
                        $request->tanggal_awal
                    );
                }


                // Filter tanggal akhir
                if ($request->filled('tanggal_akhir')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '<=',
                        $request->tanggal_akhir
                    );
                }


                $query->with([
                    'temuans'
                ]);
            }
        ])

            ->whereHas('lhps', function ($query) use ($request) {


                if ($request->jenis == 'internal') {

                    $query->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } elseif ($request->jenis == 'eksternal') {

                    $query->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }


                if ($request->filled('tanggal_awal')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '>=',
                        $request->tanggal_awal
                    );
                }


                if ($request->filled('tanggal_akhir')) {

                    $query->whereDate(
                        'tanggal_lhp',
                        '<=',
                        $request->tanggal_akhir
                    );
                }
            })

            ->get();


        return view(
            'pages.laporan.pihak-ketiga-temuan',
            compact('pihakKetiga')
        );
    }
    public function pnsTemuan(Request $request)
    {
        // Default tampil internal
        if (!$request->filled('jenis')) {
            $request->merge([
                'jenis' => 'internal'
            ]);
        }


        $lhps = Lhp::with([
            'auditee',
            'pejabatAuditee',
            'temuans.rekomendasis'
        ])
            ->whereHas('temuans');


        // Filter jenis pemeriksaan
        if ($request->jenis == 'internal') {

            $lhps->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        } elseif ($request->jenis == 'eksternal') {

            $lhps->whereIn(
                'instansi_pemeriksa',
                [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]
            );
        }


        // Filter tanggal
        if ($request->filled('tanggal_awal')) {

            $lhps->whereDate(
                'tanggal_lhp',
                '>=',
                $request->tanggal_awal
            );
        }


        if ($request->filled('tanggal_akhir')) {

            $lhps->whereDate(
                'tanggal_lhp',
                '<=',
                $request->tanggal_akhir
            );
        }


        $lhps = $lhps->latest()->get();

        $jenis = $request->jenis;
        return view(
            'pages.laporan.pns-temuan',
            compact('lhps', 'jenis')
        );
    }

    public function cetakPnsTemuan(Request $request)
    {

        // Default internal
        if (!$request->filled('jenis')) {

            $request->merge([
                'jenis' => 'internal'
            ]);
        }


        $lhps = Lhp::with([

            'auditee',
            'pejabatAuditee',
            'temuans.rekomendasis'

        ])
            ->whereHas('temuans');



        /*
    |--------------------------------------------------------------------------
    | Filter Jenis Pemeriksaan
    |--------------------------------------------------------------------------
    */

        if ($request->jenis == 'internal') {

            $lhps->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        } elseif ($request->jenis == 'eksternal') {

            $lhps->whereIn(
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
    | Filter Tanggal
    |--------------------------------------------------------------------------
    */

        if ($request->filled('tanggal_awal')) {

            $lhps->whereDate(
                'tanggal_lhp',
                '>=',
                $request->tanggal_awal
            );
        }


        if ($request->filled('tanggal_akhir')) {

            $lhps->whereDate(
                'tanggal_lhp',
                '<=',
                $request->tanggal_akhir
            );
        }



        $lhps = $lhps
            ->latest()
            ->get();



        $inspektur = Pegawai::where(
            'jabatan',
            'Inspektur Kabupaten Ketapang'
        )->first();



        $sekretaris = Pegawai::where(
            'jabatan',
            'Sekretaris'
        )->first();



        return view(
            'pages.laporan.cetak-pns-temuan',
            compact(
                'lhps',
                'inspektur',
                'sekretaris'
            )
        );
    }

    public function cetakIrban(Request $request)
    {
        $inspektur = Pegawai::where('jabatan', 'Inspektur Kabupaten Ketapang')->first();
        $sekretaris = Pegawai::where('jabatan', 'Sekretaris')->first();

        $tahun = null;
        $bulan = null;

        if ($request->filled('tanggal_awal')) {
            $tanggal = \Carbon\Carbon::parse($request->tanggal_awal);
            $tahun = $tanggal->format('Y');
            $bulan = $tanggal->translatedFormat('F');
        }

        if ($request->filled('irban_id')) {

            $laporan = [
                $this->getLaporanIrban($request)
            ];

            $irbanPegawai = Pegawai::where('irban_id', $request->irban_id)
                ->first();

            return view(
                'pages.laporan.cetak-irban',
                compact(
                    'laporan',
                    'tahun',
                    'bulan',
                    'irbanPegawai',
                    'inspektur',
                    'sekretaris'
                )
            );
        }

        $laporan = $this->getLaporanSemuaIrban($request);

        return view(
            'pages.laporan.cetak-semua-irban',
            compact(
                'laporan',
                'tahun',
                'bulan',
                'inspektur',
                'sekretaris'
            )
        );
    }

    public function cetak(Request $request)
    {
        $inspektur = Pegawai::where(
            'jabatan',
            'Inspektur Kabupaten Ketapang'
        )->first();

        $sekretaris = Pegawai::where(
            'jabatan',
            'Sekretaris'
        )->first();
        $laporan = $this->getLaporan($request);

        $periode = null;
        $jenis = $request->jenis;

        if ($request->filled('tanggal_awal')) {

            $tanggal = \Carbon\Carbon::parse($request->tanggal_awal);

            $periode = [
                'bulan' => strtoupper($tanggal->translatedFormat('F')),
                'tahun' => $tanggal->format('Y')
            ];
        }


        return view(
            "pages.laporan.cetak",
            compact(
                "laporan",
                "periode",
                'inspektur',
                'sekretaris',
                'jenis'
            )
        );
    }

    private function getLaporan(Request $request)
    {
        $query = Irban::with([
            "lhps" => function ($lhp) use ($request) {
                // Filter Internal / Eksternal
                if ($request->filled('jenis')) {


                    if ($request->jenis == 'internal') {

                        $lhp->where(
                            'instansi_pemeriksa',
                            'Itkab'
                        );
                    } elseif ($request->jenis == 'eksternal') {

                        $lhp->whereIn(
                            'instansi_pemeriksa',
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    }
                }
                if ($request->filled("tanggal_awal")) {
                    $lhp->whereDate(
                        "tanggal_lhp",
                        ">=",
                        $request->tanggal_awal
                    );
                }

                if ($request->filled("tanggal_akhir")) {
                    $lhp->whereDate(
                        "tanggal_lhp",
                        "<=",
                        $request->tanggal_akhir
                    );
                }

                $lhp->with(["temuans.rekomendasis.tindakLanjut"]);
            },
        ]);



        $irbans = $query->orderBy("nama_irban")->get();

        $laporan = [];

        foreach ($irbans as $irban) {
            $totalLhp = $irban->lhps->count();

            /*
        |--------------------------------------------------------------------------
        | Jika LHP kosong tampil NIHIL
        |--------------------------------------------------------------------------
        */

            if ($totalLhp == 0) {
                $laporan[] = [
                    "nihil" => true,

                    "wilayah" => $irban->nama_irban,

                    "lhp" => 0,

                    "temuan" => 0,

                    "rekomendasi" => 0,

                    "selesai" => 0,

                    "persen_selesai" => 0,

                    "dalam_proses" => 0,

                    "persen_proses" => 0,

                    "belum" => 0,

                    "persen_belum" => 0,

                    "kerugian" => 0,

                    "disetor" => 0,

                    "persen_kerugian" => 0,

                    "sisa_kerugian" => 0,

                    "pajak" => 0,

                    "pajak_disetor" => 0,

                    "persen_pajak" => 0,

                    "sisa_pajak" => 0,
                ];

                continue;
            }

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

                        $nilaiKerugian += $rekomendasi->nilai_finansial ?? 0;

                        $nilaiPajak += $rekomendasi->nilai_pajak ?? 0;

                        /*
                    |--------------------------------------------------------------------------
                    | Ambil tindak lanjut TERAKHIR
                    |--------------------------------------------------------------------------
                    */

                        $tlTerakhir = $rekomendasi->tindakLanjut
                            ->sortByDesc("created_at")
                            ->first();

                        if (!$tlTerakhir) {
                            $belum++;
                        } else {
                            if ($tlTerakhir->status_id == 3) {
                                $selesai++;
                            } elseif ($tlTerakhir->status_id == 2) {
                                $dalamProses++;
                            } else {
                                $belum++;
                            }

                            $nilaiDisetor +=
                                $tlTerakhir->nilai_pengembalian ?? 0;

                            $nilaiPajakDisetor +=
                                $tlTerakhir->nilai_setor_pajak ?? 0;
                        }
                    }
                }
            }

            $laporan[] = [
                "nihil" => false,

                "wilayah" => $irban->nama_irban,

                "lhp" => $totalLhp,

                "temuan" => $totalTemuan,

                "rekomendasi" => $totalRekomendasi,

                "selesai" => $selesai,

                "persen_selesai" =>
                $totalRekomendasi > 0
                    ? round(($selesai / $totalRekomendasi) * 100, 2)
                    : 0,

                "dalam_proses" => $dalamProses,

                "persen_proses" =>
                $totalRekomendasi > 0
                    ? round(($dalamProses / $totalRekomendasi) * 100, 2)
                    : 0,

                "belum" => $belum,

                "persen_belum" =>
                $totalRekomendasi > 0
                    ? round(($belum / $totalRekomendasi) * 100, 2)
                    : 0,

                "kerugian" => $nilaiKerugian,

                "disetor" => $nilaiDisetor,

                "sisa_kerugian" => $nilaiKerugian - $nilaiDisetor,

                "pajak" => $nilaiPajak,

                "pajak_disetor" => $nilaiPajakDisetor,

                "sisa_pajak" => $nilaiPajak - $nilaiPajakDisetor,

                "persen_kerugian" =>
                $nilaiKerugian > 0
                    ? round(($nilaiDisetor / $nilaiKerugian) * 100, 2)
                    : 0,

                "persen_pajak" =>
                $nilaiPajak > 0
                    ? round(($nilaiPajakDisetor / $nilaiPajak) * 100, 2)
                    : 0,
            ];
        }

        return $laporan;
    }

    public function index(Request $request)
    {
        $laporan = $this->getLaporan($request);

        $listIrban = Irban::orderBy("nama_irban")->get();
        $jenis = $request->jenis;
        return view(
            "pages.laporan.index",

            compact(
                "laporan",
                'jenis',
                "listIrban"
            )
        );
    }

    private function getLaporanIrban(Request $request)
    {
        $irban = Irban::with([
            "lhps" => function ($query) use ($request) {
                if ($request->jenis == 'internal') {


                    $query->where(
                        'instansi_pemeriksa',
                        'Itkab'
                    );
                } elseif ($request->jenis == 'eksternal') {


                    $query->whereIn(
                        'instansi_pemeriksa',
                        [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]
                    );
                }
                if ($request->filled("tanggal_awal")) {
                    $query->whereDate(
                        "tanggal_lhp",
                        ">=",
                        $request->tanggal_awal
                    );
                }

                if ($request->filled("tanggal_akhir")) {
                    $query->whereDate(
                        "tanggal_lhp",
                        "<=",
                        $request->tanggal_akhir
                    );
                }

                $query->where('status_proses', '!=', 'nihil');

                $query->with([
                    'temuans.rekomendasis.tindakLanjut'
                ]);
            },
        ])->find($request->irban_id);


        if (!$irban) {
            return null;
        }

        $data = [
            "wilayah" => $irban->nama_irban,

            "lhp" => [],
        ];


        if ($irban->lhps->count() == 0) {
            $data["nihil"] = true;

            return $data;
        }

        $data["nihil"] = false;

        foreach ($irban->lhps as $lhp) {
            $item = [
                "nomor" => $lhp->nomor_lhp,

                "tanggal" => $lhp->tanggal_lhp,

                'obrik' => $lhp->objek_pemeriksaan,

                "temuan" => 0,

                "rekomendasi" => 0,

                "selesai" => 0,

                "dalam_proses" => 0,

                "belum" => 0,

                "kerugian" => 0,

                "disetor" => 0,

                "sisa" => 0,

                "pajak" => 0,

                "pajak_disetor" => 0,

                "pajak_sisa" => 0,

            ];

            foreach ($lhp->temuans as $temuan) {
                $item["temuan"]++;

                foreach ($temuan->rekomendasis as $rek) {
                    $item["rekomendasi"]++;

                    $item["kerugian"] += $rek->nilai_finansial ?? 0;

                    $item["pajak"] += $rek->nilai_pajak ?? 0;

                    $tl = $rek->tindakLanjut->sortByDesc("created_at")->first();

                    if (!$tl) {
                        $item["belum"]++;
                    } elseif ($tl->status_id == 3) {
                        $item["selesai"]++;
                    } elseif ($tl->status_id == 2) {
                        $item["dalam_proses"]++;
                    } else {
                        $item["belum"]++;
                    }

                    if ($tl) {
                        $item["disetor"] += $tl->nilai_pengembalian ?? 0;

                        $item["pajak_disetor"] += $tl->nilai_setor_pajak ?? 0;
                    }
                }
            }

            $item["sisa"] = $item["kerugian"] - $item["disetor"];

            $item["pajak_sisa"] = $item["pajak"] - $item["pajak_disetor"];

            $data["lhp"][] = $item;
        }

        return $data;
    }

    private function getLaporanSemuaIrban(Request $request)
    {
        $irbans = Irban::with([
            "lhps" => function ($query) use ($request) {

                if ($request->filled('jenis')) {


                    if ($request->jenis == 'internal') {

                        $query->where(
                            'instansi_pemeriksa',
                            'Itkab'
                        );
                    } elseif ($request->jenis == 'eksternal') {

                        $query->whereIn(
                            'instansi_pemeriksa',
                            [
                                'Itprov',
                                'BPK RI',
                                'BPKP'
                            ]
                        );
                    }
                }

                if ($request->filled("tanggal_awal")) {

                    $query->whereDate(
                        "tanggal_lhp",
                        ">=",
                        $request->tanggal_awal
                    );
                }


                if ($request->filled("tanggal_akhir")) {

                    $query->whereDate(
                        "tanggal_lhp",
                        "<=",
                        $request->tanggal_akhir
                    );
                }


                $query->where('status_proses', '!=', 'nihil');


                $query->with([
                    'temuans.rekomendasis.tindakLanjut'
                ]);
            },

        ])
            ->orderBy('nama_irban')
            ->get();



        $laporan = [];



        foreach ($irbans as $irban) {


            $data = [

                "wilayah" => $irban->nama_irban,

                "lhp" => [],

                "nihil" => false

            ];



            /*
        |--------------------------------------------------------------------------
        | Jika Irban tidak memiliki LHP
        |--------------------------------------------------------------------------
        */


            if ($irban->lhps->count() == 0) {


                $data["nihil"] = true;


                $laporan[] = $data;


                continue;
            }




            /*
        |--------------------------------------------------------------------------
        | Loop LHP
        |--------------------------------------------------------------------------
        */


            foreach ($irban->lhps as $lhp) {


                $item = [


                    "nomor" => $lhp->nomor_lhp,


                    "tanggal" => $lhp->tanggal_lhp,
                    'wilayah' => $irban->nama_irban,

                    "obrik" => $lhp->objek_pemeriksaan,


                    "temuan" => 0,


                    "rekomendasi" => 0,


                    "selesai" => 0,


                    "dalam_proses" => 0,


                    "belum" => 0,


                    "kerugian" => 0,


                    "disetor" => 0,


                    "sisa" => 0,


                    "pajak" => 0,


                    "pajak_disetor" => 0,


                    "pajak_sisa" => 0,


                ];




                foreach ($lhp->temuans as $temuan) {


                    $item["temuan"]++;



                    foreach ($temuan->rekomendasis as $rek) {



                        $item["rekomendasi"]++;



                        $item["kerugian"] += $rek->nilai_finansial ?? 0;



                        $item["pajak"] += $rek->nilai_pajak ?? 0;




                        /*
                    |--------------------------------------------------------------------------
                    | Ambil tindak lanjut terakhir
                    |--------------------------------------------------------------------------
                    */


                        $tl = $rek->tindakLanjut
                            ->sortByDesc('created_at')
                            ->first();




                        if (!$tl) {


                            $item["belum"]++;
                        } elseif ($tl->status_id == 3) {


                            $item["selesai"]++;
                        } elseif ($tl->status_id == 2) {


                            $item["dalam_proses"]++;
                        } else {


                            $item["belum"]++;
                        }




                        if ($tl) {


                            $item["disetor"] +=
                                $tl->nilai_pengembalian ?? 0;



                            $item["pajak_disetor"] +=
                                $tl->nilai_setor_pajak ?? 0;
                        }
                    }
                }




                $item["sisa"] =
                    $item["kerugian"] -
                    $item["disetor"];



                $item["pajak_sisa"] =
                    $item["pajak"] -
                    $item["pajak_disetor"];




                $data["lhp"][] = $item;
            }



            $laporan[] = $data;
        }



        return $laporan;
    }

    public function irban(Request $request)
    {
        $listIrban = Irban::orderBy('nama_irban')->get();

        $laporan = null;

        // Halaman pertama kali dibuka
        if (!$request->has('tanggal_awal') && !$request->has('tanggal_akhir')) {

            return view(
                'pages.laporan.irban',
                compact('listIrban', 'laporan')
            );
        }

        if ($request->filled('irban_id')) {

            $laporan = $this->getLaporanIrban($request);

            return view(
                'pages.laporan.irban',
                compact('laporan', 'listIrban')
            );
        }

        $laporan = $this->getLaporanSemuaIrban($request);

        return view(
            'pages.laporan.semua-irban',
            compact('laporan', 'listIrban')
        );
    }
    public function cetakSemuaIrban(Request $request)
    {
        $inspektur = Pegawai::where('jabatan', 'Inspektur Kabupaten Ketapang')->first();
        $sekretaris = Pegawai::where('jabatan', 'Sekretaris')->first();


        $tahun = null;
        $bulan = null;


        if ($request->filled('tanggal_awal')) {

            $tanggal = \Carbon\Carbon::parse($request->tanggal_awal);

            $tahun = $tanggal->format('Y');
            $bulan = $tanggal->translatedFormat('F');
        }


        $laporan = $this->getLaporanSemuaIrban($request);


        return view(
            'pages.laporan.semua-irban',
            compact(
                'laporan',
                'tahun',
                'bulan',
                'inspektur',
                'sekretaris'
            )
        );
    }
}
