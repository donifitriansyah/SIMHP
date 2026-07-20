<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EditRequest;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    /**
     * Form tambah rekomendasi
     */
    public function create(Temuan $temuan)
    {
        return view("pages.pemeriksaan.rekomendasi.create", compact("temuan"));
    }

    /**
     * Simpan rekomendasi
     */
    public function store(Request $request, Temuan $temuan)
    {
        $request->validate([
            'uraian_rekomendasi' => 'required|string',
            'administrasi'       => 'nullable|string',
            'nilai_finansial'    => 'nullable|string',
            'nilai_pajak'        => 'nullable|string',
        ]);

        try {

            $nilaiFinansial = null;
            $nilaiPajak = null;

            if ($request->filled('nilai_finansial')) {
                $nilaiFinansial = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_finansial
                );
            }

            if ($request->filled('nilai_pajak')) {
                $nilaiPajak = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_pajak
                );
            }

            Rekomendasi::create([
                'temuan_id'          => $temuan->id,
                'uraian_rekomendasi' => $request->uraian_rekomendasi,
                'administrasi'       => $request->administrasi,
                'nilai_finansial'    => $nilaiFinansial,
                'nilai_pajak'        => $nilaiPajak,
            ]);

            $temuan->lhp->updateStatusProses();
            $temuan->lhp->updateStatusLhp();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aksi' => 'Edit',
                'modul' => 'Rekomendasi',
                'referensi_id' => $temuan->id,
                'deskripsi' => 'Mengedit Rekomendasi pada LHP ' . $temuan->lhp->nomor_lhp,
            ]);

            return redirect()
                ->route('lhp.show', $temuan->lhp_id)
                ->with('success', 'Rekomendasi berhasil ditambahkan.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Rekomendasi gagal ditambahkan. ' . $e->getMessage()
                );
        }
    }

    /**
     * Form edit rekomendasi
     */
    public function edit(Rekomendasi $rekomendasi)
    {
        $lhp = $rekomendasi->temuan->lhp;


        if (!auth()->user()->canEditLhp($lhp)) {
            abort(403);
        }
        return view(
            "pages.pemeriksaan.rekomendasi.edit",
            compact("rekomendasi")
        );
    }

    public function update(Request $request, Rekomendasi $rekomendasi)
    {
        $request->validate([
            'uraian_rekomendasi' => 'required|string',
            'administrasi'       => 'nullable|string',
            'nilai_finansial'    => 'nullable|string',
            'nilai_pajak'        => 'nullable|string',
        ]);

        try {

            $nilaiFinansial = null;
            $nilaiPajak = null;

            if ($request->filled('nilai_finansial')) {
                $nilaiFinansial = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_finansial
                );
            }

            if ($request->filled('nilai_pajak')) {
                $nilaiPajak = str_replace(
                    ['.', ','],
                    ['', '.'],
                    $request->nilai_pajak
                );
            }

            $rekomendasi->update([
                'uraian_rekomendasi' => $request->uraian_rekomendasi,
                'administrasi'       => $request->administrasi,
                'nilai_finansial'    => $nilaiFinansial,
                'nilai_pajak'        => $nilaiPajak,
            ]);

            $rekomendasi->temuan->lhp->updateStatusProses();
            $rekomendasi->temuan->lhp->updateStatusLhp();

            EditRequest::where('lhp_id', $rekomendasi->temuan->lhp_id)
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->update([
                    'edit_rekomendasi' => true
                ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'aksi' => 'Edit',
                'modul' => 'Rekomendasi',
                'referensi_id' => $rekomendasi->id,
                'deskripsi' => 'Mengedit Rekomendasi pada LHP ' . $rekomendasi->lhp->nomor_lhp,
            ]);

            return redirect()
                ->route('lhp.show', $rekomendasi->temuan->lhp_id)
                ->with('success', 'Rekomendasi berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Rekomendasi gagal diperbarui. ' . $e->getMessage()
                );
        }
    }


    public function destroy(Rekomendasi $rekomendasi)
    {
        $lhp = $rekomendasi->temuan->lhp;

        $lhp_id = $lhp->id;

        $rekomendasi->delete();

        // cek ulang status LHP
        $rekomendasi->temuan->lhp->updateStatusLhp();

        return redirect()
            ->route("lhp.show", $lhp_id)

            ->with("success", "Rekomendasi berhasil dihapus");
    }
}
