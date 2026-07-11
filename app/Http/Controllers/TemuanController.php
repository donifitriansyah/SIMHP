<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Temuan;
use Illuminate\Http\Request;


class TemuanController extends Controller
{


    /**
     * Menampilkan form tambah temuan
     */
    public function create(Lhp $lhp)
    {

        return view(
            'pages.pemeriksaan.temuan.create',
            compact('lhp')
        );
    }



    /**
     * Simpan data temuan
     */
    public function store(Request $request, Lhp $lhp)
    {

        $request->validate([

            'nomor_temuan' => 'required',
            'uraian_temuan' => 'required',
            'administrasi' => 'nullable',
            'nilai_kerugian' => 'nullable',
            'nama_pelaku' => 'nullable'

        ]);



        $temuan = Temuan::create([

            'lhp_id' => $lhp->id,

            'nomor_temuan' => $request->nomor_temuan,

            'uraian_temuan' => $request->uraian_temuan,

            'administrasi' => $request->administrasi,

            'nilai_kerugian' => $request->nilai_kerugian
                ? str_replace('.', '', $request->nilai_kerugian)
                : null,

            'nama_pelaku' => $request->nama_pelaku

        ]);





        // Update status LHP otomatis
        $lhp->update([

            'status_proses' => 'dalam_proses'

        ]);


        $lhp->updateStatusLhp();



        return redirect()

            ->route('lhp.show', $lhp->id)

            ->with(
                'success',
                'Data temuan berhasil ditambahkan'
            );
    }



    /**
     * Form edit temuan
     */
    public function edit(Temuan $temuan)
    {


        return view(
            'pages.pemeriksaan.temuan.edit',
            compact('temuan')
        );
    }



    /**
     * Update temuan
     */
    public function update(Request $request, Temuan $temuan)
    {


        $request->validate([

            'nomor_temuan' => 'required',
            'uraian_temuan' => 'required',
            'administrasi' => 'nullable',
            'nilai_kerugian' => 'nullable',
            'nama_pelaku' => 'nullable'

        ]);


        $temuan->update([


            'nomor_temuan' => $request->nomor_temuan,


            'uraian_temuan' => $request->uraian_temuan,


            'administrasi' => $request->administrasi,


            'nilai_kerugian' => $request->nilai_kerugian
                ? str_replace('.', '', $request->nilai_kerugian)
                : null,


            'nama_pelaku' => $request->nama_pelaku


        ]);


        return redirect()
            ->route(
                'lhp.show',
                $temuan->lhp_id
            )
            ->with(
                'success',
                'Data temuan berhasil diperbarui'
            );
    }

    /**
     * Hapus temuan
     */
    public function destroy(Temuan $temuan)
    {


        $lhp_id = $temuan->lhp_id;


        $temuan->delete();



        return redirect()
            ->route(
                'lhp.show',
                $lhp_id
            )
            ->with(
                'success',
                'Data temuan berhasil dihapus'
            );
    }
}
