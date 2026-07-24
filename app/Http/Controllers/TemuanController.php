<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DetailTemuanFinansial;
use App\Models\EditRequest;
use App\Models\Irban;
use App\Models\Lhp;
use App\Models\Pegawai;
use App\Models\PihakKetiga;
use App\Models\Temuan;
use Illuminate\Http\Request;


class TemuanController extends Controller
{

    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'internal';

        $user = auth()->user();

        $query = Temuan::with([
            'lhp.irban',
            'lhp.auditee',
            'rekomendasis'
        ]);

        $query->whereHas('lhp', function ($q) use ($jenis, $user) {

            if ($jenis == 'internal') {
                $q->where('instansi_pemeriksa', 'Itkab');
            } else {
                $q->whereIn('instansi_pemeriksa', [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]);
            }

            // User View hanya melihat irban miliknya
            if ($user->isUserView()) {
                $q->where('irban_id', $user->irban_id);
            }
        });

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('uraian_temuan', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pelaku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('irban_id')) {
            $query->whereHas('lhp', function ($q) use ($request) {
                $q->where('irban_id', $request->irban_id);
            });
        }

        $irbans = Irban::all();

        $temuans = $query
            ->latest()
            ->get();

        return view('pages.pemeriksaan.temuan.index', compact(
            'temuans',
            'jenis',
            'irbans'
        ));
    }
    /**
     * Menampilkan form tambah temuan
     */
    public function create(Lhp $lhp)
    {
        $pegawais = Pegawai::with('skpd')
            ->orderBy('nama')
            ->get();

        $pihakKetigas = PihakKetiga::orderBy('nama_perusahaan')
            ->get();
        return view(
            'pages.pemeriksaan.temuan.create',
            compact('lhp', 'pegawais', 'pihakKetigas')
        );
    }



    /**
     * Simpan data temuan
     */
    public function store(Request $request, Lhp $lhp)
    {
        $request->validate([
            'uraian_temuan'  => 'required|string',
            'administrasi'   => 'nullable|string',
            'nilai_kerugian' => 'nullable|string',
            'nama_pelaku' => 'nullable|string|max:255',
            'jenis_finansial' => 'nullable|in:pns,penyedia',
            'detail_finansial.pegawai_id.*' => 'nullable|exists:pegawai,id',
            'detail_finansial.pihak_ketiga_id.*' => 'nullable|exists:pihak_ketiga,id',
            'detail_finansial.nilai.*' => 'nullable',
        ]);

        try {

            $nilaiKerugian = null;

            if ($request->filled('nilai_kerugian')) {
                $nilaiKerugian = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_kerugian
                );
            }

            $nomorTemuan = $lhp->temuans()->count() + 1;

            $temuan = Temuan::create([
                'lhp_id'           => $lhp->id,
                'nomor_temuan' => $nomorTemuan,
                'uraian_temuan'    => $request->uraian_temuan,
                'administrasi'     => $request->administrasi,
                'nilai_kerugian'   => $nilaiKerugian,
                'nama_pelaku'      => $request->nama_pelaku,
            ]);
            if (
                $request->filled('jenis_finansial') &&
                $request->filled('detail_finansial')
            ) {


                foreach (
                    $request->detail_finansial['nilai'] as $index => $nilai
                ) {


                    if (!$nilai) {
                        continue;
                    }


                    DetailTemuanFinansial::create([

                        'temuan_id' => $temuan->id,

                        'jenis' => $request->jenis_finansial,

                        'pegawai_id' =>
                        $request->jenis_finansial == 'pns'
                            ? $request->detail_finansial['pegawai_id'][$index]
                            : null,

                        'pihak_ketiga_id' =>
                        $request->jenis_finansial == 'penyedia'
                            ? $request->detail_finansial['pihak_ketiga_id'][$index]
                            : null,

                        'nilai_temuan' => str_replace(
                            ['.', ','],
                            ['', '.'],
                            $nilai
                        ),

                    ]);
                }
            }
            $lhp->updateStatusProses();
            $lhp->updateStatusLhp();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aksi' => 'Tambah',
                'modul' => 'Temuan',
                'referensi_id' => $temuan->id,
                'deskripsi' => 'Menambahkan Temuan pada LHP ' . $temuan->lhp->nomor_lhp,
            ]);

            return redirect()
                ->route('lhp.show', $lhp->id)
                ->with('success', 'Data temuan berhasil ditambahkan.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Data temuan gagal ditambahkan. ' . $e->getMessage());
        }
    }

    public function update(Request $request, Temuan $temuan)
    {
        $request->validate([
            'uraian_temuan'      => 'required|string',
            'administrasi'       => 'nullable|string',
            'nilai_kerugian'     => 'nullable|string',
            'nama_pelaku'        => 'nullable|string|max:255',

            'jenis_finansial'    => 'nullable|in:pns,penyedia',

            'detail_finansial.pegawai_id.*'      => 'nullable|exists:pegawais,id',
            'detail_finansial.pihak_ketiga_id.*' => 'nullable|exists:pihak_ketiga,id',
            'detail_finansial.nilai.*'           => 'nullable',
        ]);

        try {

            $nilaiKerugian = null;

            if ($request->filled('nilai_kerugian')) {
                $nilaiKerugian = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_kerugian
                );
            }

            $temuan->update([
                'uraian_temuan'  => $request->uraian_temuan,
                'administrasi'   => $request->administrasi,
                'nilai_kerugian' => $nilaiKerugian,
                'nama_pelaku'    => $request->nama_pelaku,
            ]);

            /*
        |--------------------------------------------------------------------------
        | Detail Finansial
        |--------------------------------------------------------------------------
        */

            $temuan->detailFinansial()->delete();

            if ($request->filled('jenis_finansial')) {

                $jenis = $request->jenis_finansial;
                $nilaiList = $request->detail_finansial['nilai'] ?? [];

                if ($jenis == 'pns') {

                    $pegawaiList = $request->detail_finansial['pegawai_id'] ?? [];

                    foreach ($pegawaiList as $index => $pegawaiId) {

                        if (empty($pegawaiId)) {
                            continue;
                        }

                        $temuan->detailFinansial()->create([
                            'jenis'            => 'pns',
                            'pegawai_id'       => $pegawaiId,
                            'pihak_ketiga_id'  => null,
                            'nilai_temuan'     => str_replace('.', '', $nilaiList[$index] ?? 0),
                        ]);
                    }
                }

                if ($jenis == 'penyedia') {

                    $pihakKetigaList = $request->detail_finansial['pihak_ketiga_id'] ?? [];

                    foreach ($pihakKetigaList as $index => $pihakKetigaId) {

                        if (empty($pihakKetigaId)) {
                            continue;
                        }

                        $temuan->detailFinansial()->create([
                            'jenis'            => 'penyedia',
                            'pegawai_id'       => null,
                            'pihak_ketiga_id'  => $pihakKetigaId,
                            'nilai_temuan'     => str_replace('.', '', $nilaiList[$index] ?? 0),
                        ]);
                    }
                }
            }

            $temuan->lhp->updateStatusLhp();
            $temuan->lhp->updateStatusProses();

            EditRequest::where('lhp_id', $temuan->lhp_id)
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->update([
                    'edit_temuan' => true
                ]);

            ActivityLog::create([
                'user_id'      => auth()->id(),
                'aksi'         => 'Edit',
                'modul'        => 'Temuan',
                'referensi_id' => $temuan->id,
                'deskripsi'    => 'Mengedit Temuan pada LHP ' . $temuan->lhp->nomor_lhp,
            ]);

            return redirect()
                ->route('lhp.show', $temuan->lhp_id)
                ->with('success', 'Data temuan berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data temuan gagal diperbarui. ' . $e->getMessage()
                );
        }
    }
    /**
     * Form edit temuan
     */
    public function edit(Temuan $temuan)
    {
        $lhp = $temuan->lhp;
        $pegawais = Pegawai::with('skpd')->orderBy('nama')->get();
        $pihakKetigas = PihakKetiga::orderBy('nama_perusahaan')->get();
        
        return view(
            'pages.pemeriksaan.temuan.edit',
            compact(
                'temuan',
                'pegawais',
                'pihakKetigas'
            )
        );
    }



    /**
     * Update temuan
     */


    /**
     * Hapus temuan
     */
    public function destroy(Temuan $temuan)
    {
        $lhp = $temuan->lhp;

        $lhp_id = $lhp->id;

        /*
    |--------------------------------------------------------------------------
    | Hapus Detail Finansial
    |--------------------------------------------------------------------------
    */

        $temuan->detailFinansial()->delete();

        /*
    |--------------------------------------------------------------------------
    | Hapus Rekomendasi dan Tindak Lanjut
    |--------------------------------------------------------------------------
    */

        foreach ($temuan->rekomendasis as $rekomendasi) {


            // hapus tindak lanjut
            $rekomendasi->tindakLanjut()->delete();


            // hapus rekomendasi
            $rekomendasi->delete();
        }



        /*
    |--------------------------------------------------------------------------
    | Hapus Temuan
    |--------------------------------------------------------------------------
    */

        $temuan->delete();


        /*
    |--------------------------------------------------------------------------
    | Reset Nomor Temuan
    |--------------------------------------------------------------------------
    */

        $temuans = Temuan::where('lhp_id', $lhp_id)
            ->orderBy('id')
            ->get();

        foreach ($temuans as $index => $item) {


            $item->update([

                'nomor_temuan' => $index + 1

            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Update Status LHP
    |--------------------------------------------------------------------------
    */

        $lhp->updateStatusLhp();

        $lhp->updateStatusProses();

        return redirect()
            ->route('lhp.show', $lhp_id)
            ->with(
                'success',
                'Data temuan berhasil dihapus'
            );
    }
}
