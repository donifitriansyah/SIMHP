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
            'nomor_temuan'   => 'required|string|max:50',
            'uraian_temuan'  => 'required|string',
            'administrasi'   => 'nullable|string',
            'nilai_kerugian' => 'nullable|string',
            'nama_pelaku'    => 'nullable|string|max:255',
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

            Temuan::create([
                'lhp_id'           => $lhp->id,
                'nomor_temuan'     => $request->nomor_temuan,
                'uraian_temuan'    => $request->uraian_temuan,
                'administrasi'     => $request->administrasi,
                'nilai_kerugian'   => $nilaiKerugian,
                'nama_pelaku'      => $request->nama_pelaku,
            ]);
            $lhp->updateStatusProses();
            $lhp->updateStatusLhp();


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
            'nomor_temuan'   => 'required|string|max:50',
            'uraian_temuan'  => 'required|string',
            'administrasi'   => 'nullable|string',
            'nilai_kerugian' => 'nullable|string',
            'nama_pelaku'    => 'nullable|string|max:255',
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
                'nomor_temuan'    => $request->nomor_temuan,
                'uraian_temuan'   => $request->uraian_temuan,
                'administrasi'    => $request->administrasi,
                'nilai_kerugian'  => $nilaiKerugian,
                'nama_pelaku'     => $request->nama_pelaku,
            ]);

            $temuan->lhp->updateStatusLhp();
            $temuan->lhp->updateStatusProses();

            return redirect()
                ->route('lhp.show', $temuan->lhp_id)
                ->with('success', 'Data temuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Data temuan gagal diperbarui. ' . $e->getMessage());
        }
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


    /**
     * Hapus temuan
     */
    public function destroy(Temuan $temuan)
    {
        $lhp = $temuan->lhp;

        $lhp_id = $lhp->id;

        $temuan->delete();

        // Update status LHP setelah temuan dihapus
        $lhp->updateStatusLhp();

        return redirect()
            ->route('lhp.show', $lhp_id)
            ->with(
                'success',
                'Data temuan berhasil dihapus'
            );
    }
}
