<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Auditee;
use App\Models\EditRequest;
use App\Models\Irban;
use App\Models\Lhp;
use App\Models\LhpObjekPemeriksaan;
use App\Models\PejabatAuditee;
use App\Models\PenandatanganLaporan;
use App\Models\PihakKetiga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LhpController extends Controller
{

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

    public function index(Request $request, $jenis = null)
    {
        $query = Lhp::with([
            'irban',
            'auditee',
            'temuans.rekomendasis.tindakLanjut.status',
            'objekPemeriksaans',
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


                $q->where(
                    'nomor_lhp',
                    'like',
                    "%{$keyword}%"
                )


                    ->orWhereHas('objekPemeriksaans', function ($objek) use ($keyword) {


                        $objek->where(
                            'nama_objek',
                            'like',
                            "%{$keyword}%"
                        );
                    })


                    ->orWhereHas('auditee', function ($a) use ($keyword) {


                        $a->where(
                            'nama_dinas',
                            'like',
                            "%{$keyword}%"
                        );
                    });
            });
        }
        if ($jenis == 'internal') {

            if ($request->filled('irban_id')) {
                $query->where('irban_id', $request->irban_id);
            }
        } elseif ($jenis == 'eksternal') {

            if ($request->filled('instansi_pemeriksa')) {
                $query->where(
                    'instansi_pemeriksa',
                    $request->instansi_pemeriksa
                );
            }
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


            'belum_ditindaklanjuti' => (clone $statistikQuery)
                ->where(
                    'status_proses',
                    'belum_ditindaklanjuti'
                )
                ->count(),


            'dalam_proses' => (clone $statistikQuery)
                ->where(
                    'status_proses',
                    'dalam_proses'
                )
                ->count(),


            'selesai' => (clone $statistikQuery)
                ->where(
                    'status_proses',
                    'selesai'
                )
                ->count(),


            'tt' => (clone $statistikQuery)
                ->where(
                    'status_proses',
                    'tt'
                )
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

    public function tetapkanTT(Lhp $lhp)
    {
        $lhp->update([
            'status_proses' => 'tt'
        ]);


        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Edit',
            'modul' => 'LHP',
            'referensi_id' => $lhp->id,
            'deskripsi' =>
            'Menetapkan LHP ' . $lhp->nomor_lhp .
                ' sebagai Tidak Dapat Ditindaklanjuti'
        ]);


        return back()->with(
            'success',
            'LHP berhasil ditetapkan sebagai Tidak Dapat Ditindaklanjuti.'
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

            case 'tt':

                $query->where('status_proses', 'tt');

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

            'irban_id' => 'nullable|exists:irban,id',

            'nama_pejabat_eksternal' => 'nullable|string|max:255',

            'auditee_id' => 'nullable|exists:auditee,id',

            'pejabat_auditee_id' => 'nullable|array',

            'pejabat_auditee_id.*' => 'exists:pejabat_auditee,id',

            'pihak_ketiga_id' => 'nullable|array',

            'pihak_ketiga_id.*' => 'exists:pihak_ketiga,id',

            'objek_pemeriksaan' => 'required|array',

            'objek_pemeriksaan.*' => 'required|string|max:255',

            'instansi_pemeriksa' => 'nullable|in:Itkab,Itprov,BPK RI,BPKP',

            'nomor_lhp' => 'required|unique:lhp,nomor_lhp',

            'nomor_spt' => 'required|unique:lhp,nomor_spt',

            'tanggal_lhp' => 'required|date',

            'tanggal_spt' => 'required|date',

            'tahun_pkpt' => 'required',

            'jenis_pemeriksaan' => 'required',

            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);


        if (
            in_array($request->instansi_pemeriksa, ['Itkab', 'Itprov'])
            && empty($request->irban_id)
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'irban_id' => 'Irban wajib dipilih.'
                ]);
        }



        // Simpan LHP utama
        $lhp = Lhp::create([


            'irban_id' => in_array(
                $request->instansi_pemeriksa,
                ['BPK RI', 'BPKP']
            )
                ? null
                : $request->irban_id,


            'auditee_id' => $request->auditee_id,


            'instansi_pemeriksa' => $request->instansi_pemeriksa,


            'nama_pejabat_eksternal' => $request->nama_pejabat_eksternal,


            'nomor_lhp' => $request->nomor_lhp,


            'tanggal_lhp' => $request->tanggal_lhp,


            'nomor_spt' => $request->nomor_spt,


            'tanggal_spt' => $request->tanggal_spt,


            'tahun_pkpt' => $request->tahun_pkpt,


            'jumlah_dana_diawasi' => $request->filled('jumlah_dana_diawasi')
                ? str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->jumlah_dana_diawasi
                )
                : null,


            'jenis_pemeriksaan' => $request->jenis_pemeriksaan,


            'status_lhp' => 'tidak_lengkap',


            'status_proses' => 'belum_ditindaklanjuti',

        ]);



        /*
    |--------------------------------------------------------------------------
    | Simpan Pejabat Auditee
    |--------------------------------------------------------------------------
    */

        if ($request->filled('pejabat_auditee_id')) {

            $lhp->pejabatAuditees()
                ->sync($request->pejabat_auditee_id);
        }



        /*
    |--------------------------------------------------------------------------
    | Simpan Pihak Ketiga
    |--------------------------------------------------------------------------
    */

        if ($request->filled('pihak_ketiga_id')) {

            $lhp->pihakKetigas()
                ->sync($request->pihak_ketiga_id);
        }



        /*
    |--------------------------------------------------------------------------
    | Simpan Objek Pemeriksaan
    |--------------------------------------------------------------------------
    */

        if ($request->filled('objek_pemeriksaan')) {


            foreach ($request->objek_pemeriksaan as $objek) {


                $lhp->objekPemeriksaans()
                    ->create([

                        'nama_objek' => $objek

                    ]);
            }
        }



        /*
    |--------------------------------------------------------------------------
    | Upload Dokumen
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('dokumen')) {


            foreach ($request->file('dokumen') as $file) {


                $path = $file->store(
                    'dokumen-lhp',
                    'public'
                );


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

            // Banyak pejabat diperiksa
            'pejabatAuditees.pejabatAuditee',

            // Banyak pihak ketiga
            'pihakKetigas',

            'objekPemeriksaans',

            'temuans.rekomendasis.tindakLanjut',
            'dokumen',

            'temuans.detailFinansial.pegawai',
            'temuans.detailFinansial.perangkatDesa',
            'temuans.detailFinansial.pihakKetiga',
            'temuans.detailFinansial.pihakLain',
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

            // banyak pejabat
            'pejabatAuditees.pejabatAuditee',

            // banyak pihak ketiga
            'pihakKetigas',

            // banyak objek pemeriksaan
            'objekPemeriksaans',


            'temuans.detailFinansial',

            'temuans.rekomendasis.tindakLanjut.status',

            'dokumen'

        ]);


        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';



        $penandatangan = PenandatanganLaporan::where('jabatan', 'inspektur')
            ->where('status', true)
            ->first();



        return view(
            'pages.pemeriksaan.lhp.cetak',
            compact(
                'lhp',
                'jenis',
                'penandatangan'
            )
        );
    }

    public function previewPdf(Lhp $lhp)
    {
        $lhp->load([
            'irban',
            'auditee',
            'pejabatAuditee',
            'pihakKetiga',

            'temuans.detailFinansial.pegawai',
            'temuans.detailFinansial.perangkatDesa',
            'temuans.detailFinansial.pihakKetiga',
            'temuans.detailFinansial.pihakLain',

            'temuans.rekomendasis',
            'temuans.rekomendasis.tindakLanjut.status',
            'temuans.rekomendasis.tindakLanjut.dokumen',

            'dokumen'
        ]);

        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';

        return view(
            'pages.pemeriksaan.lhp.cetak',
            compact('lhp', 'jenis')
        );
    }

    public function hapusObjek($id)
    {

        $objek = LhpObjekPemeriksaan::findOrFail($id);


        $objek->delete();


        return response()->json([
            'success' => true
        ]);
    }

    public function edit(Lhp $lhp)
    {
        $lhp->load([
            'pejabatAuditees',
            'pihakKetigas',
            'objekPemeriksaans'
        ]);

        $irbans = Irban::all();
        $auditees = Auditee::all();
        $pihakKetigas = PihakKetiga::all();


        $jenis = $lhp->instansi_pemeriksa == 'Itkab'
            ? 'internal'
            : 'eksternal';


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

            'irban_id' => 'nullable|exists:irban,id',
            'auditee_id' => 'nullable|exists:auditee,id',

            'pejabat_auditee_id' => 'nullable|array',
            'pejabat_auditee_id.*' => 'exists:pejabat_auditee,id',

            'pihak_ketiga_id' => 'nullable|array',
            'pihak_ketiga_id.*' => 'exists:pihak_ketiga,id',

            'nama_pejabat_eksternal' => 'nullable|string|max:255',

            'instansi_pemeriksa'
            => 'nullable|in:Itkab,Itprov,BPK RI,BPKP',

            'objek_pemeriksaan' => 'required|array',
            'objek_pemeriksaan.*' => 'required|string|max:255',

            'objek_id' => 'nullable|array',

            'nomor_lhp' => [
                'required',
                Rule::unique('lhp', 'nomor_lhp')
                    ->ignore($lhp->id),
            ],

            'nomor_spt' => [
                'required',
                Rule::unique('lhp', 'nomor_spt')
                    ->ignore($lhp->id),
            ],

            'tanggal_lhp' => 'required|date',
            'tanggal_spt' => 'required|date',
            'tahun_pkpt' => 'required',
            'jenis_pemeriksaan' => 'required',

            'dokumen.*'
            => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',

        ]);


        /*
    |--------------------------------------------------------------------------
    | UPDATE DATA UTAMA LHP
    |--------------------------------------------------------------------------
    */

        $lhp->update([

            'irban_id' => $request->irban_id,

            'auditee_id' => $request->auditee_id,

            'nama_pejabat_eksternal'
            => $request->nama_pejabat_eksternal,

            'instansi_pemeriksa'
            => $request->instansi_pemeriksa,


            'nomor_lhp' => $request->nomor_lhp,

            'tanggal_lhp' => $request->tanggal_lhp,

            'nomor_spt' => $request->nomor_spt,

            'tanggal_spt' => $request->tanggal_spt,

            'tahun_pkpt' => $request->tahun_pkpt,


            'jumlah_dana_diawasi' => $request->filled('jumlah_dana_diawasi')
                ? str_replace(
                    ',',
                    '.',
                    str_replace(
                        '.',
                        '',
                        $request->jumlah_dana_diawasi
                    )
                )
                : null,


            'jenis_pemeriksaan'
            => $request->jenis_pemeriksaan,

        ]);



        /*
    |--------------------------------------------------------------------------
    | UPDATE PEJABAT AUDITEE
    |--------------------------------------------------------------------------
    */

        $lhp->pejabatAuditees()->delete();


        if ($request->pejabat_auditee_id) {

            foreach ($request->pejabat_auditee_id as $pejabat) {

                $lhp->pejabatAuditees()->create([

                    'pejabat_auditee_id' => $pejabat,

                ]);
            }
        }



        /*
    |--------------------------------------------------------------------------
    | UPDATE PIHAK KETIGA
    |--------------------------------------------------------------------------
    */

        $lhp->pihakKetigas()->sync(
            $request->pihak_ketiga_id ?? []
        );



        /*
    |--------------------------------------------------------------------------
    | UPDATE OBJEK PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

        $objekIds = $request->objek_id ?? [];


        // hapus objek yang sudah dihapus dari form

        $lhp->objekPemeriksaans()
            ->whereNotIn('id', $objekIds)
            ->delete();



        foreach ($request->objek_pemeriksaan as $index => $nama) {


            if (isset($objekIds[$index])) {


                // update objek lama

                LhpObjekPemeriksaan::where(
                    'id',
                    $objekIds[$index]
                )->update([

                    'nama_objek' => $nama

                ]);
            } else {


                // tambah objek baru

                $lhp->objekPemeriksaans()->create([

                    'nama_objek' => $nama

                ]);
            }
        }



        /*
    |--------------------------------------------------------------------------
    | UPLOAD DOKUMEN
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('dokumen')) {


            foreach ($request->file('dokumen') as $file) {


                $path = $file->store(
                    'dokumen-lhp',
                    'public'
                );


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
                'Data LHP berhasil diperbarui.'
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
