<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Auditee;
use App\Models\EditRequest;
use App\Models\Irban;
use App\Models\Lhp;
use App\Models\PejabatAuditee;
use App\Models\PihakKetiga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    // public function index(Request $request)
    // {
    //     $query = Lhp::with([
    //         'irban',
    //         'auditee',
    //         'temuans.rekomendasis.tindakLanjut.status'
    //     ]);


    //     if ($request->filled('keyword')) {

    //         $keyword = $request->keyword;

    //         $query->where(function ($q) use ($keyword) {

    //             $q->where('nomor_lhp', 'like', "%{$keyword}%")
    //                 ->orWhere('objek_pemeriksaan', 'like', "%{$keyword}%")
    //                 ->orWhereHas('auditee', function ($a) use ($keyword) {

    //                     $a->where('nama_dinas', 'like', "%{$keyword}%");
    //                 });
    //         });
    //     }

    //     if ($request->filled('irban_id')) {

    //         $query->where('irban_id', $request->irban_id);
    //     }



    //     if ($request->filled('status')) {

    //         $query->where('status_proses', $request->status);
    //     }


    //     if ($request->filled('tanggal_awal')) {

    //         $query->whereDate(
    //             'tanggal_lhp',
    //             '>=',
    //             $request->tanggal_awal
    //         );
    //     }

    //     if ($request->filled('tanggal_akhir')) {

    //         $query->whereDate(
    //             'tanggal_lhp',
    //             '<=',
    //             $request->tanggal_akhir
    //         );
    //     }


    //     $lhps = $query
    //         ->withCount('temuans')
    //         ->latest()
    //         ->paginate(10)
    //         ->withQueryString();


    //     foreach ($lhps as $lhp) {

    //         $totalRekomendasi = 0;
    //         $totalSelesai = 0;

    //         foreach ($lhp->temuans as $temuan) {

    //             foreach ($temuan->rekomendasis as $rekomendasi) {

    //                 $totalRekomendasi++;

    //                 // Ambil tindak lanjut terakhir
    //                 $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
    //                     ->sortByDesc('created_at')
    //                     ->first();

    //                 if (
    //                     $tindakLanjutTerakhir &&
    //                     $tindakLanjutTerakhir->status &&
    //                     $tindakLanjutTerakhir->status->kode == 'S'
    //                 ) {
    //                     $totalSelesai++;
    //                 }
    //             }
    //         }

    //         $lhp->totalRekomendasi = $totalRekomendasi;
    //         $lhp->totalSelesai = $totalSelesai;

    //         $lhp->progress = $totalRekomendasi > 0
    //             ? round(($totalSelesai / $totalRekomendasi) * 100)
    //             : 0;
    //     }


    //     $statistik = [

    //         'total' => Lhp::count(),

    //         'nihil' => Lhp::where('status_proses', 'nihil')->count(),

    //         'belum_proses' => Lhp::where('status_proses', 'belum_diproses')->count(),

    //         'dalam_proses' => Lhp::where('status_proses', 'dalam_proses')->count(),

    //         'selesai' => Lhp::where('status_proses', 'selesai')->count(),

    //     ];

    //     $irbans = Irban::orderBy('nama_irban')->get();

    //     return view(
    //         'pages.pemeriksaan.lhp.index',
    //         compact(
    //             'lhps',
    //             'statistik',
    //             'irbans'
    //         )
    //     );
    // }

    public function index(Request $request, $jenis = null)
    {
        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status'
        ]);
        // User View hanya melihat LHP sesuai Irban
        if (auth()->user()->isUserView()) {
            $query->where('irban_id', auth()->user()->irban_id);
        }
        // Filter Internal / Eksternal
        if ($jenis == 'internal') {

            $query->where('instansi_pemeriksa', 'Itkab');
        } elseif ($jenis == 'eksternal') {

            $query->whereIn('instansi_pemeriksa', [
                'Itprov',
                'BPK RI',
                'BPKP'
            ]);
        }
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

            $query->where(
                'irban_id',
                $request->irban_id
            );
        }
        if ($request->filled('status')) {

            $query->where(
                'status_proses',
                $request->status
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
        $lhps = $query
            ->withCount('temuans')
            ->latest()
            ->get();
        foreach ($lhps as $lhp) {

            $totalRekomendasi = 0;
            $totalSelesai = 0;


            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $totalRekomendasi++;


                    $tindakLanjutTerakhir = $rekomendasi
                        ->tindakLanjut
                        ->sortByDesc('id')
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


        // Statistik mengikuti menu yang sedang dibuka
        // Statistik mengikuti menu yang sedang dibuka
        $statistikQuery = Lhp::query();

        if ($jenis == 'internal') {

            $statistikQuery->where('instansi_pemeriksa', 'Itkab');
        } elseif ($jenis == 'eksternal') {

            $statistikQuery->whereIn('instansi_pemeriksa', [
                'Itprov',
                'BPK RI',
                'BPKP'
            ]);
        }

        // Jika User View, hanya statistik Irban miliknya
        if (auth()->user()->isUserView()) {
            $statistikQuery->where('irban_id', auth()->user()->irban_id);
        }

        $statistik = [

            'total' => (clone $statistikQuery)->count(),

            'nihil' => (clone $statistikQuery)
                ->where('status_proses', 'nihil')
                ->count(),

            'belum_proses' => (clone $statistikQuery)
                ->where('status_proses', 'belum_diproses')
                ->count(),

            'dalam_proses' => (clone $statistikQuery)
                ->where('status_proses', 'dalam_proses')
                ->count(),

            'selesai' => (clone $statistikQuery)
                ->where('status_proses', 'selesai')
                ->count(),

        ];


        if (auth()->user()->isUserView()) {

            $irbans = Irban::where('id', auth()->user()->irban_id)->get();
        } else {

            $irbans = Irban::orderBy('nama_irban')->get();
        }



        return view(
            'pages.pemeriksaan.lhp.index',
            compact(
                'lhps',
                'statistik',
                'irbans',
                'jenis'
            )
        );
    }

    public function lengkap(Request $request)
    {
        $jenis = $request->jenis ?? 'internal';

        $user = auth()->user();


        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis'
        ])
            ->where('status_lhp', 'lengkap');


        // Filter internal / eksternal
        if ($jenis == 'internal') {

            $query->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        } else {

            $query->whereIn(
                'instansi_pemeriksa',
                [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]
            );
        }


        // User View hanya melihat Irban sendiri
        if ($user->isUserView()) {

            $query->where(
                'irban_id',
                $user->irban_id
            );
        }


        $lhps = $query
            ->latest()
            ->get();


        return view(
            'pages.pemeriksaan.lhp.lengkap',
            compact(
                'lhps',
                'jenis'
            )
        );
    }

    public function belumLengkap(Request $request)
    {
        $jenis = $request->jenis ?? 'internal';

        $user = auth()->user();


        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans'
        ])
            ->where('status_lhp', 'tidak_lengkap');


        // Filter Internal / Eksternal
        if ($jenis == 'internal') {

            $query->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        } else {

            $query->whereIn(
                'instansi_pemeriksa',
                [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]
            );
        }


        // User View hanya melihat irban sendiri
        if ($user->isUserView()) {

            $query->where(
                'irban_id',
                $user->irban_id
            );
        }


        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'nomor_lhp',
                    'like',
                    '%' . $request->search . '%'
                )
                    ->orWhere(
                        'objek_pemeriksaan',
                        'like',
                        '%' . $request->search . '%'
                    );
            });
        }


        $lhps = $query
            ->latest()
            ->get();


        return view(
            'pages.pemeriksaan.lhp.belum-lengkap',
            compact(
                'lhps',
                'jenis'
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


        $lhps = $query->get();


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

    public function create($jenis = null)
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
                'jenis'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'irban_id'             => 'nullable|exists:irban,id',
            'nama_pejabat_eksternal' => 'nullable|string|max:255',
            'auditee_id'           => 'nullable|exists:auditee,id',
            'pejabat_auditee_id'   => 'nullable|exists:pejabat_auditee,id',
            'instansi_pemeriksa'   => 'nullable|in:Itkab,Itprov,BPK RI,BPKP',
            'objek_pemeriksaan'    => 'required',

            'nomor_lhp' => 'required|unique:lhp,nomor_lhp',

            'nomor_spt' => 'required|unique:lhp,nomor_spt',
            'tanggal_lhp'          => 'required|date',

            'tanggal_spt'          => 'required|date',

            'tahun_pkpt'           => 'required',

            'jenis_pemeriksaan'    => 'required',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);

        if (in_array($request->instansi_pemeriksa, ['Itkab', 'Itprov']) && empty($request->irban_id)) {
            return back()
                ->withInput()
                ->withErrors([
                    'irban_id' => 'Irban wajib dipilih.'
                ]);
        }

        $lhp = Lhp::create([

            'irban_id' => in_array($request->instansi_pemeriksa, ['BPK RI', 'BPKP'])
                ? null
                : $request->irban_id,

            'auditee_id'           => $request->auditee_id,

            'pejabat_auditee_id'   => $request->pejabat_auditee_id,

            'instansi_pemeriksa'  => $request->instansi_pemeriksa,

            'nama_pejabat_eksternal' => $request->nama_pejabat_eksternal,

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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Tambah',
            'modul' => 'LHP',
            'referensi_id' => $lhp->id,
            'deskripsi' => 'Menambahkan LHP ' . $lhp->nomor_lhp,
        ]);

        return redirect()
            ->route(
                $request->instansi_pemeriksa == 'Itkab'
                    ? 'pemeriksaan.internal'
                    : 'pemeriksaan.eksternal'
            )
            ->with(
                'success',
                'Data LHP berhasil ditambah'
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

        $editRequest = EditRequest::where('lhp_id', $lhp->id)
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';

        return view(
            'pages.pemeriksaan.lhp.show',
            compact(
                'lhp',
                'jenis',
                'editRequest'
            )
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


        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';


        return view(
            'pages.pemeriksaan.lhp.cetak',
            compact(
                'lhp',
                'jenis'
            )
        );
    }

    public function edit(Lhp $lhp)
    {
        $irbans = Irban::all();
        $auditees = Auditee::all();
        $pihakKetigas = PihakKetiga::all();


        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';

        if (!auth()->user()->canEditLhp($lhp)) {
            abort(403);
        }


        return view(
            'pages.pemeriksaan.lhp.edit',
            compact(
                'lhp',
                'irbans',
                'auditees',
                'pihakKetigas',
                'jenis'
            )
        );
    }

    public function update(Request $request, Lhp $lhp)
    {
        $request->validate([

            'irban_id'             => 'required|exists:irban,id',
            'auditee_id'           => 'nullable|exists:auditee,id',
            'nama_pejabat_eksternal' => 'nullable|string|max:255',
            'pejabat_auditee_id'   => 'nullable|exists:pejabat_auditee,id',

            'objek_pemeriksaan'    => 'required',
            'instansi_pemeriksa'   => 'nullable|in:Itkab,Itprov,BPK RI,BPKP',

            'nomor_lhp' => [
                'required',
                Rule::unique('lhp', 'nomor_lhp')
                    ->ignore($lhp->id)
            ],


            'nomor_spt' => [
                'required',
                Rule::unique('lhp', 'nomor_spt')
                    ->ignore($lhp->id)
            ],
            'tanggal_lhp'          => 'required|date',

            'tanggal_spt'          => 'required|date',

            'tahun_pkpt'           => 'required',

            'jenis_pemeriksaan'    => 'required',

            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);

        $lhp->update([

            'irban_id'             => $request->irban_id,

            'auditee_id'           => $request->auditee_id,

            'nama_pejabat_eksternal' => $request->nama_pejabat_eksternal,

            'instansi_pemeriksa'  => $request->instansi_pemeriksa,

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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Edit',
            'modul' => 'LHP',
            'referensi_id' => $lhp->id,
            'deskripsi' => 'Mengedit LHP ' . $lhp->nomor_lhp,
        ]);

        return redirect()
            ->route(
                $lhp->instansi_pemeriksa == 'Itkab'
                    ? 'pemeriksaan.internal'
                    : 'pemeriksaan.eksternal'
            )
            ->with(
                'success',
                'Data LHP berhasil diupdate'
            );
    }

    public function destroy(Lhp $lhp)
    {

        $lhp->delete();


        return redirect()
            ->route(
                $lhp->instansi_pemeriksa == 'Itkab'
                    ? 'pemeriksaan.internal'
                    : 'pemeriksaan.eksternal'
            )
            ->with(
                'success',
                'Data LHP berhasil dihapus'
            );
    }
}
