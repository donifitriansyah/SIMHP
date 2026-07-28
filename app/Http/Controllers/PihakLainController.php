<?php

namespace App\Http\Controllers;

use App\Models\PihakLain;
use Illuminate\Http\Request;

class PihakLainController extends Controller
{
    /**
     * Menampilkan data pihak lain
     */
    public function index()
    {
        $pihakLain = PihakLain::orderBy('nama')->get();

        return view(
            'pages.master-data.pihak-lain.index',
            compact('pihakLain')
        );
    }

    /**
     * Menyimpan data
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        PihakLain::create([
            'nama'   => $request->nama,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('pihak-lain.index')
            ->with('success', 'Data Pihak Lain berhasil ditambahkan.');
    }

    /**
     * Update data
     */
    public function update(Request $request, PihakLain $pihakLain)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $pihakLain->update([
            'nama'   => $request->nama,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('pihak-lain.index')
            ->with('success', 'Data Pihak Lain berhasil diperbarui.');
    }

    /**
     * Hapus data
     */
    public function destroy(PihakLain $pihakLain)
    {
        if ($pihakLain->detailTemuanFinansial()->exists()) {

            return back()->with(
                'error',
                'Data tidak dapat dihapus karena sudah digunakan pada Detail Temuan Finansial.'
            );
        }

        $pihakLain->delete();

        return redirect()
            ->route('pihak-lain.index')
            ->with('success', 'Data Pihak Lain berhasil dihapus.');
    }
}
