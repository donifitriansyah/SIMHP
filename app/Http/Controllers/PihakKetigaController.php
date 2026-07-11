<?php

namespace App\Http\Controllers;

use App\Models\PihakKetiga;
use Illuminate\Http\Request;

class PihakKetigaController extends Controller
{
    /**
     * Menampilkan data pihak ketiga
     */
    public function index()
    {
        $pihakKetigas = PihakKetiga::latest()->paginate(10);

        return view('pages.master-data.pihak-ketiga.index', compact('pihakKetigas'));
    }


    public function store(Request $request)
    {

        $request->validate([

            'nama_perusahaan' => 'required',
            'nama_pimpinan' => 'required',
            'alamat' => 'nullable',
            'paket_pekerjaan' => 'nullable',

        ]);


        PihakKetiga::create([

            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_pimpinan' => $request->nama_pimpinan,
            'alamat' => $request->alamat,
            'paket_pekerjaan' => $request->paket_pekerjaan,

        ]);


        return redirect()
            ->route('pihak-ketiga.index')
            ->with(
                'success',
                'Data pihak ketiga berhasil ditambahkan'
            );
    }



    public function update(Request $request, PihakKetiga $pihakKetiga)
    {

        $request->validate([

            'nama_perusahaan' => 'required',
            'nama_pimpinan' => 'required',
            'alamat' => 'nullable',
            'paket_pekerjaan' => 'nullable',

        ]);



        $pihakKetiga->update([

            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_pimpinan' => $request->nama_pimpinan,
            'alamat' => $request->alamat,
            'paket_pekerjaan' => $request->paket_pekerjaan,

        ]);



        return redirect()
            ->route('pihak-ketiga.index')
            ->with(
                'success',
                'Data pihak ketiga berhasil diperbarui'
            );
    }



    public function destroy(PihakKetiga $pihakKetiga)
    {

        $pihakKetiga->delete();


        return redirect()
            ->route('pihak-ketiga.index')
            ->with(
                'success',
                'Data pihak ketiga berhasil dihapus'
            );
    }
}
