<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use Illuminate\Http\Request;

class PerangkatDesaController extends Controller
{
    /**
     * Menampilkan data perangkat desa
     */
    public function index()
    {
        $perangkatDesa = PerangkatDesa::orderBy('nama')
            ->get();

        return view(
            'pages.master-data.perangkat-desa.index',
            compact('perangkatDesa')
        );
    }

    /**
     * Menyimpan data perangkat desa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'jabatan'    => 'required|string|max:150',
            'desa'       => 'required|string|max:150',
            'kecamatan'  => 'nullable|string|max:150',
            'status'     => 'required|boolean',
        ]);

        PerangkatDesa::create([
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'desa'       => $request->desa,
            'kecamatan'  => $request->kecamatan,
            'status'     => $request->status,
        ]);

        return redirect()
            ->route('perangkat-desa.index')
            ->with('success', 'Data Perangkat Desa berhasil ditambahkan.');
    }

    /**
     * Mengubah data perangkat desa
     */
    public function update(Request $request, PerangkatDesa $perangkatDesa)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'jabatan'    => 'required|string|max:150',
            'desa'       => 'required|string|max:150',
            'kecamatan'  => 'nullable|string|max:150',
            'status'     => 'required|boolean',
        ]);

        $perangkatDesa->update([
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'desa'       => $request->desa,
            'kecamatan'  => $request->kecamatan,
            'status'     => $request->status,
        ]);

        return redirect()
            ->route('perangkat-desa.index')
            ->with('success', 'Data Perangkat Desa berhasil diperbarui.');
    }

    /**
     * Menghapus data perangkat desa
     */
    public function destroy(PerangkatDesa $perangkatDesa)
    {
        if ($perangkatDesa->detailTemuanFinansial()->exists()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak dapat dihapus karena sudah digunakan pada Detail Temuan Finansial.'
                );
        }

        $perangkatDesa->delete();

        return redirect()
            ->route('perangkat-desa.index')
            ->with('success', 'Data Perangkat Desa berhasil dihapus.');
    }
}
