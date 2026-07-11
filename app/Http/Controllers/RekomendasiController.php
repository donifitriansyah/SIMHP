<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;


class RekomendasiController extends Controller
{
    /**
     * Form tambah rekomendasi
     */
    public function create(Temuan $temuan)
    {

        return view(
            'pages.pemeriksaan.rekomendasi.create',
            compact('temuan')
        );
    }

    /**
     * Simpan rekomendasi
     */
    public function store(Request $request, Temuan $temuan)
    {

        $request->validate([

            'uraian_rekomendasi' => 'required',
            'administrasi' => 'nullable',
            'nilai_finansial' => 'nullable'

        ]);


        $rekomendasi = Rekomendasi::create([

            'temuan_id' => $temuan->id,

            'uraian_rekomendasi' => $request->uraian_rekomendasi,

            'administrasi' => $request->administrasi,

            'nilai_finansial' => $request->nilai_finansial
                ? str_replace('.', '', $request->nilai_finansial)
                : null

        ]);



        // Update status kelengkapan LHP
        $temuan->lhp->updateStatusLhp();



        return redirect()

            ->route(
                'lhp.show',
                $temuan->lhp_id
            )

            ->with(
                'success',
                'Rekomendasi berhasil ditambahkan'
            );
    }

    /**
     * Form edit rekomendasi
     */
    public function edit(Rekomendasi $rekomendasi)
    {


        return view(
            'pages.pemeriksaan.rekomendasi.edit',
            compact('rekomendasi')
        );
    }

    /**
     * Update rekomendasi
     */
    public function update(Request $request, Rekomendasi $rekomendasi)
    {

        $request->validate([

            'uraian_rekomendasi' => 'required',
            'administrasi' => 'nullable',
            'nilai_finansial' => 'nullable'

        ]);

        $rekomendasi->update([


            'uraian_rekomendasi' => $request->uraian_rekomendasi,


            'administrasi' => $request->administrasi,


            'nilai_finansial' => $request->nilai_finansial
                ? str_replace('.', '', $request->nilai_finansial)
                : null


        ]);

        return redirect()

            ->route(
                'lhp.show',
                $rekomendasi->temuan->lhp_id
            )

            ->with(
                'success',
                'Rekomendasi berhasil diperbarui'
            );
    }

    /**
     * Hapus rekomendasi
     */
    public function destroy(Rekomendasi $rekomendasi)
    {

        $lhp = $rekomendasi
            ->temuan
            ->lhp;


        $lhp_id = $lhp->id;



        $rekomendasi->delete();



        // cek ulang status LHP
        $lhp->updateStatusLhp();



        return redirect()

            ->route(
                'lhp.show',
                $lhp_id
            )

            ->with(
                'success',
                'Rekomendasi berhasil dihapus'
            );
    }
}
