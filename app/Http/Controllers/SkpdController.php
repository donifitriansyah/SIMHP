<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkpdController extends Controller
{

    public function index()
    {
        $skpds = Skpd::latest()->get();

        return view('pages.master-data.skpd.index', compact('skpds'));
    }

    /**
     * Simpan data SKPD
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'wilayah_pengawasan' => 'nullable|string|max:255'
        ]);

        try {

            DB::beginTransaction();

            Skpd::create([
                'nama_skpd' => $request->nama_skpd,
                'wilayah_pengawasan' => $request->wilayah_pengawasan,
                'status' => 1,
            ]);

            DB::commit();

            return redirect()
                ->route('skpd.index')
                ->with('success', 'Data SKPD berhasil ditambahkan.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data SKPD gagal ditambahkan. ' . $e->getMessage()
                );
        }
    }

    /**
     * Update data SKPD
     */
    public function update(Request $request, Skpd $skpd)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'wilayah_pengawasan' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {

            $skpd->update([
                'nama_skpd' => $request->nama_skpd,
                'wilayah_pengawasan' => $request->wilayah_pengawasan,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('skpd.index')
                ->with('success', 'Data SKPD berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data SKPD gagal diperbarui.'
                );
        }
    }

    /**
     * Hapus data SKPD
     */
    public function destroy(Skpd $skpd)
    {
        try {

            $skpd->delete();

            return redirect()
                ->route('skpd.index')
                ->with('success', 'Data SKPD berhasil dihapus.');
        } catch (\Exception $e) {

            return back()
                ->with(
                    'error',
                    'Data SKPD gagal dihapus.'
                );
        }
    }
}
