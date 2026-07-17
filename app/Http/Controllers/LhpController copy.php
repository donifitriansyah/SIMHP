<?php

namespace App\Http\Controllers;

use App\Models\Auditee;
use App\Models\Irban;
use App\Models\Lhp;
use App\Models\PejabatAuditee;
use App\Models\PihakKetiga;
use Illuminate\Http\Request;

class LhpController extends Controller
{

    // public function index()
    // {
    //     $lhps = Lhp::with([
    //         'irban',
    //         'auditee',
    //         'pihakKetiga',
    //         'objekPemeriksaan'
    //     ])
    //         ->latest()
    //         ->paginate(10);


    //     return view(
    //         'pages.pemeriksaan.lhp.index',
    //         compact('lhps')
    //     );
    // }

    public function getPejabat($auditee)
    {
        $pejabat = PejabatAuditee::where(
            'auditee_id',
            $auditee
        )
            ->orderBy('jenis_jabatan')
            ->orderBy('nama')
            ->get();

        return response()->json($pejabat);
    }

    public function tetapkanNihil(Lhp $lhp)
    {

        // pastikan belum ada temuan
        if ($lhp->temuans()->count() > 0) {

            return back()->with(
                'error',
                'LHP sudah memiliki temuan, tidak dapat ditetapkan sebagai nihil'
            );
        }



        $lhp->update([

            'status_proses' => 'nihil'

        ]);



        return back()->with(
            'success',
            'LHP berhasil ditetapkan sebagai Nihil'
        );
    }

    public function indexInternal(Request $request)
    {
        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status'
        ])
            ->where('instansi_pemeriksa', 'Itkab');

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->where('nomor_lhp', 'like', "%{$keyword}%")
                    ->orWhere('objek_pemeriksaan', 'like', "%{$keyword}%")
                    ->orWhereHas('auditee', function ($a) use ($keyword) {

                        $a->where('nama_dinas', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('irban_id')) {
            $query->where('irban_id', $request->irban_id);
        }

        if ($request->filled('status')) {
            $query->where('status_proses', $request->status);
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

        $lhps = $query
            ->withCount('temuans')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        foreach ($lhps as $lhp) {

            $totalRekomendasi = 0;
            $totalSelesai = 0;

            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $totalRekomendasi++;

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

            $lhp->totalRekomendasi = $totalRekomendasi;
            $lhp->totalSelesai = $totalSelesai;
            $lhp->progress = $totalRekomendasi > 0
                ? round(($totalSelesai / $totalRekomendasi) * 100)
                : 0;
        }

        $statistik = [

            'total' => Lhp::where('instansi_pemeriksa', 'Itkab')->count(),

            'nihil' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'nihil')
                ->count(),

            'belum_proses' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'belum_diproses')
                ->count(),

            'dalam_proses' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'dalam_proses')
                ->count(),

            'selesai' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'selesai')
                ->count(),
        ];

        $irbans = Irban::orderBy('nama_irban')->get();

        return view(
            'pages.pemeriksaan.internal.index',
            compact(
                'lhps',
                'statistik',
                'irbans'
            )
        );
    }

    public function indexExternal(Request $request)
    {
        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status'
        ])->whereIn('instansi_pemeriksa', [
            'Itprov',
            'BPK RI',
            'BPKP'
        ]);

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->where('nomor_lhp', 'like', "%{$keyword}%")
                    ->orWhere('objek_pemeriksaan', 'like', "%{$keyword}%")
                    ->orWhereHas('auditee', function ($a) use ($keyword) {

                        $a->where('nama_dinas', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('irban_id')) {
            $query->where('irban_id', $request->irban_id);
        }

        if ($request->filled('status')) {
            $query->where('status_proses', $request->status);
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

        $lhps = $query
            ->withCount('temuans')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        foreach ($lhps as $lhp) {

            $totalRekomendasi = 0;
            $totalSelesai = 0;

            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $totalRekomendasi++;

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

            $lhp->totalRekomendasi = $totalRekomendasi;
            $lhp->totalSelesai = $totalSelesai;
            $lhp->progress = $totalRekomendasi > 0
                ? round(($totalSelesai / $totalRekomendasi) * 100)
                : 0;
        }

        $statistik = [

            'total' => Lhp::where('instansi_pemeriksa', 'Itkab')->count(),

            'nihil' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'nihil')
                ->count(),

            'belum_proses' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'belum_diproses')
                ->count(),

            'dalam_proses' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'dalam_proses')
                ->count(),

            'selesai' => Lhp::where('instansi_pemeriksa', 'Itkab')
                ->where('status_proses', 'selesai')
                ->count(),
        ];

        $irbans = Irban::orderBy('nama_irban')->get();

        return view(
            'pages.pemeriksaan.internal.index',
            compact(
                'lhps',
                'statistik',
                'irbans'
            )
        );
    }
    public function index(Request $request)
    {
        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status'
        ]);


        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->where('nomor_lhp', 'like', "%{$keyword}%")
                    ->orWhere('objek_pemeriksaan', 'like', "%{$keyword}%")
                    ->orWhereHas('auditee', function ($a) use ($keyword) {

                        $a->where('nama_dinas', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('irban_id')) {

            $query->where('irban_id', $request->irban_id);
        }



        if ($request->filled('status')) {

            $query->where('status_proses', $request->status);
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


        $lhps = $query
            ->withCount('temuans')
            ->latest()
            ->paginate(10)
            ->withQueryString();


        foreach ($lhps as $lhp) {

            $totalRekomendasi = 0;
            $totalSelesai = 0;

            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $totalRekomendasi++;

                    // Ambil tindak lanjut terakhir
                    $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
                        ->sortByDesc('created_at')
                        ->first();

                    if (
                        $tindakLanjutTerakhir &&
                        $tindakLanjutTerakhir->status &&
                        $tindakLanjutTerakhir->status->kode == 'S'
                    ) {
                        $totalSelesai++;
                    }
                }
            }

            $lhp->totalRekomendasi = $totalRekomendasi;
            $lhp->totalSelesai = $totalSelesai;

            $lhp->progress = $totalRekomendasi > 0
                ? round(($totalSelesai / $totalRekomendasi) * 100)
                : 0;
        }


        $statistik = [

            'total' => Lhp::count(),

            'nihil' => Lhp::where('status_proses', 'nihil')->count(),

            'belum_proses' => Lhp::where('status_proses', 'belum_diproses')->count(),

            'dalam_proses' => Lhp::where('status_proses', 'dalam_proses')->count(),

            'selesai' => Lhp::where('status_proses', 'selesai')->count(),

        ];

        $irbans = Irban::orderBy('nama_irban')->get();

        return view(
            'pages.pemeriksaan.lhp.index',
            compact(
                'lhps',
                'statistik',
                'irbans'
            )
        );
    }

    public function filter($status)
    {

        $query = Lhp::with([
            'auditee',
            'temuans.rekomendasis.tindakLanjut'
        ]);


        switch ($status) {

            case 'nihil':

                $query->where('status_proses', 'nihil');

                break;



            case 'belum_proses':

                $query->where('status_proses', 'belum_diproses');

                break;



            case 'dalam_proses':

                $query->where('status_proses', 'dalam_proses');

                break;



            case 'selesai':

                $query->where('status_proses', 'selesai');

                break;
        }


        $lhps = $query->paginate(10);


        return view(
            'pages.pemeriksaan.LHP.index',
            compact('lhps')
        );
    }

    public function selesai(Lhp $lhp)
    {

        foreach ($lhp->temuans as $temuan) {

            if ($temuan->rekomendasis()->count() == 0) {

                return back()->with(
                    'error',
                    'Tidak dapat menyelesaikan LHP. Masih ada temuan tanpa rekomendasi.'
                );
            }
        }



        $lhp->update([

            'status_proses' => 'selesai'

        ]);


        $lhp->updateStatusLhp();


        return back()->with(
            'success',
            'LHP berhasil diselesaikan'
        );
    }

    public function create()
    {

        $irbans = Irban::all();

        $auditees = Auditee::all();

        $pihakKetigas = PihakKetiga::all();



        return view(
            'pages.pemeriksaan.lhp.create',
            compact(
                'irbans',
                'auditees',
                'pihakKetigas',
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'irban_id'             => 'required|exists:irban,id',
            'auditee_id'           => 'required|exists:auditee,id',
            'pejabat_auditee_id'   => 'required|exists:pejabat_auditee,id',
            'instansi_pemeriksa'   => 'required|in:Itkab,Itprov,BPK RI,BPKP',
            'objek_pemeriksaan'    => 'required',

            'nomor_lhp'            => 'required',
            'tanggal_lhp'          => 'required|date',

            'nomor_spt'            => 'required',
            'tanggal_spt'          => 'required|date',

            'tahun_pkpt'           => 'required',

            'jenis_pemeriksaan'    => 'required',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);

        $lhp = Lhp::create([

            'irban_id'             => $request->irban_id,

            'auditee_id'           => $request->auditee_id,

            'pejabat_auditee_id'   => $request->pejabat_auditee_id,

            'instansi_pemeriksa'  => $request->instansi_pemeriksa,

            'pihak_ketiga_id'      => $request->pihak_ketiga_id,

            'objek_pemeriksaan'    => $request->objek_pemeriksaan,

            'nomor_lhp'            => $request->nomor_lhp,

            'tanggal_lhp'          => $request->tanggal_lhp,

            'nomor_spt'            => $request->nomor_spt,

            'tanggal_spt'          => $request->tanggal_spt,

            'tahun_pkpt'           => $request->tahun_pkpt,

            'jumlah_dana_diawasi' => $request->filled('jumlah_dana_diawasi')
                ? str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->jumlah_dana_diawasi
                )
                : null,

            'jenis_pemeriksaan'    => $request->jenis_pemeriksaan,

            'status_lhp'           => 'tidak_lengkap',

            'status_proses'        => 'belum_diproses',

        ]);

        if ($request->hasFile('dokumen')) {

            foreach ($request->file('dokumen') as $file) {

                $path = $file->store('dokumen-lhp', 'public');

                $lhp->dokumen()->create([

                    'nama_file' => $file->getClientOriginalName(),

                    'path_file' => $path,

                    'tipe_file' => $file->getClientOriginalExtension(),

                ]);
            }
        }

        return redirect()
            ->route('lhp.index')
            ->with(
                'success',
                'Data LHP berhasil ditambahkan'
            );
    }

    public function show(Lhp $lhp)
    {

        $lhp->load([

            'irban',
            'auditee',
            'pejabatAuditee',
            'pihakKetiga',
            'temuans.rekomendasis.tindakLanjut',
            'dokumen'

        ]);


        return view(
            'pages.pemeriksaan.lhp.show',
            compact('lhp')
        );
    }

    public function cetak(Lhp $lhp)
    {
        $lhp->load([
            'irban',
            'auditee',
            'pejabatAuditee',
            'pihakKetiga',
            'temuans.rekomendasis.tindakLanjut.status',
            'temuans.rekomendasis.tindakLanjut.dokumen',
            'dokumen'
        ]);

        return view(
            'pages.pemeriksaan.lhp.cetak',
            compact('lhp')
        );
    }

    public function edit(Lhp $lhp)
    {

        $irbans = Irban::all();

        $auditees = Auditee::all();

        $pihakKetigas = PihakKetiga::all();

        $pejabats = PejabatAuditee::where(
            'auditee_id',
            $lhp->auditee_id
        )->get();


        return view(
            'pages.pemeriksaan.lhp.edit',
            compact(
                'lhp',
                'irbans',
                'auditees',
                'pihakKetigas',
                'pejabats',
            )
        );
    }

    public function update(Request $request, Lhp $lhp)
    {
        $request->validate([

            'irban_id'             => 'required|exists:irban,id',
            'auditee_id'           => 'required|exists:auditee,id',
            'pejabat_auditee_id'   => 'required|exists:pejabat_auditee,id',

            'objek_pemeriksaan'    => 'required',

            'nomor_lhp'            => 'required',
            'tanggal_lhp'          => 'required|date',

            'nomor_spt'            => 'required',
            'tanggal_spt'          => 'required|date',

            'tahun_pkpt'           => 'required',

            'jenis_pemeriksaan'    => 'required',

            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);

        $lhp->update([

            'irban_id'             => $request->irban_id,

            'auditee_id'           => $request->auditee_id,

            'pejabat_auditee_id'   => $request->pejabat_auditee_id,

            'pihak_ketiga_id'      => $request->pihak_ketiga_id,

            'objek_pemeriksaan'    => $request->objek_pemeriksaan,

            'nomor_lhp'            => $request->nomor_lhp,

            'tanggal_lhp'          => $request->tanggal_lhp,

            'nomor_spt'            => $request->nomor_spt,

            'tanggal_spt'          => $request->tanggal_spt,

            'tahun_pkpt'           => $request->tahun_pkpt,

            'jumlah_dana_diawasi' => $request->filled('jumlah_dana_diawasi')
                ? str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->jumlah_dana_diawasi
                )
                : null,

            'jenis_pemeriksaan'    => $request->jenis_pemeriksaan,

        ]);

        // Upload dokumen baru (tidak menghapus dokumen lama)
        if ($request->hasFile('dokumen')) {

            foreach ($request->file('dokumen') as $file) {

                $path = $file->store('dokumen-lhp', 'public');

                $lhp->dokumen()->create([

                    'nama_file' => $file->getClientOriginalName(),

                    'path_file' => $path,

                    'tipe_file' => $file->getClientOriginalExtension(),

                ]);
            }
        }

        return redirect()
            ->route('lhp.index')
            ->with('success', 'Data LHP berhasil diperbarui');
    }

    public function destroy(Lhp $lhp)
    {

        $lhp->delete();


        return redirect()
            ->route('lhp.index')
            ->with(
                'success',
                'Data LHP berhasil dihapus'
            );
    }
}
