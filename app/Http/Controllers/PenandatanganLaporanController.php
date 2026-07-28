<?php

namespace App\Http\Controllers;

use App\Models\PenandatanganLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenandatanganLaporanController extends Controller
{
    /**
     * Tampilkan data penandatangan
     */
    public function index()
    {

        $data = PenandatanganLaporan::orderBy('jabatan')->get();

        $bisaTambah = $data->count() < 2;

        return view(
            'pages.master-data.penandatangan.index',
            compact('data', 'bisaTambah')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|in:Inspektur,Sekretaris',
            'nama' => 'required|string|max:255',
            'golongan' => 'required|string|max:50',
            'nip' => 'required|string|max:30',
        ]);

        $cek = PenandatanganLaporan::where('jabatan', $request->jabatan)->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->with('error', $request->jabatan . ' sudah ada.');
        }

        PenandatanganLaporan::create([
            'jabatan'  => $request->jabatan,
            'nama'     => $request->nama,
            'golongan' => $request->golongan,
            'nip'      => $request->nip,
        ]);

        return redirect()
            ->route('penandatangan.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, PenandatanganLaporan $penandatangan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'golongan' => 'required|string|max:50',
            'nip' => 'required|string|max:30',
            'status' => 'required|boolean',
        ]);

        $penandatangan->update($validated);

        return redirect()
            ->route('penandatangan.index')
            ->with('success', 'Data berhasil diperbarui.');
    }
}
