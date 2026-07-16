<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Irban;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar pegawai
     */
    public function index()
    {
        $pegawais = Pegawai::with('irban')
            ->orderBy('nama')
            ->get();

        $irbans = Irban::orderBy('nama_irban')->get();

        $jabatanTerpakai = Pegawai::pluck('jabatan')->toArray();

        return view('pages.master-data.pegawai.index', compact('pegawais', 'irbans','jabatanTerpakai'));
    }

    /**
     * Form tambah pegawai
     */
    public function create()
    {
        $irbans = Irban::orderBy('nama_irban')->get();

        return view('pages.pegawai.create', compact('irbans'));
    }

    /**
     * Simpan pegawai
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nip'       => 'required|string|max:30|unique:pegawais,nip',
            'jabatan'   => 'required|string|max:150',
            'golongan'  => 'nullable|string|max:30',
            'irban_id'  => 'nullable|exists:irban,id',
        ], [
            'nama.required' => 'Nama pegawai wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'irban_id.exists' => 'Irban tidak ditemukan.'
        ]);

        $jabatanUnik = [
            'Inspektur Kabupaten Ketapang',
            'Sekretaris',
            'Inspektur Pembantu I',
            'Inspektur Pembantu II',
            'Inspektur Pembantu III',
            'Inspektur Pembantu IV',
        ];

        if (in_array($request->jabatan, $jabatanUnik)) {

            $ada = Pegawai::where('jabatan', $request->jabatan)->exists();

            if ($ada) {
                return back()
                    ->withInput()
                    ->with('error', 'Jabatan ' . $request->jabatan . ' sudah memiliki pegawai.');
            }
        }

        Pegawai::create([
            'nama'      => $request->nama,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'golongan'  => $request->golongan,
            'irban_id'  => $request->irban_id ?: null,
        ]);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nip'       => 'required|string|max:30|unique:pegawais,nip,' . $pegawai->id,
            'jabatan'   => 'required|string|max:150',
            'golongan'  => 'nullable|string|max:30',
            'irban_id'  => 'nullable|exists:irban,id',
        ], [
            'nama.required'     => 'Nama pegawai wajib diisi.',
            'nip.required'      => 'NIP wajib diisi.',
            'nip.unique'        => 'NIP sudah digunakan.',
            'jabatan.required'  => 'Jabatan wajib diisi.',
            'irban_id.exists'   => 'Irban tidak ditemukan.',
        ]);

        $jabatanUnik = [
            'Inspektur Kabupaten Ketapang',
            'Sekretaris',
            'Inspektur Pembantu I',
            'Inspektur Pembantu II',
            'Inspektur Pembantu III',
            'Inspektur Pembantu IV',
        ];

        if (in_array($request->jabatan, $jabatanUnik)) {

            $ada = Pegawai::where('jabatan', $request->jabatan)
                ->where('id', '!=', $pegawai->id)
                ->exists();

            if ($ada) {
                return back()
                    ->withInput()
                    ->with('error', 'Jabatan ' . $request->jabatan . ' sudah memiliki pegawai.');
            }
        }

        $pegawai->update([
            'nama'      => $request->nama,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'golongan'  => $request->golongan,
            'irban_id'  => $request->irban_id ?: null,
        ]);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
