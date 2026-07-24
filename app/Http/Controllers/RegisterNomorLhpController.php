<?php

namespace App\Http\Controllers;

use App\Models\RegisterNomorLhp;
use App\Models\Irban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterNomorLhpController extends Controller
{

    /**
     * Menampilkan data register dokumen
     */
    public function index(Request $request)
    {
        $query = RegisterNomorLhp::with('irban');


        // Filter Tim Pemeriksa
        if ($request->filled('irban_id')) {

            $query->where(
                'irban_id',
                $request->irban_id
            );

        }


        // Filter Jenis Dokumen
        if ($request->filled('jenis_dokumen')) {

            $query->where(
                'jenis_dokumen',
                $request->jenis_dokumen
            );

        }


        // Filter tanggal SPT
        if ($request->filled('tanggal_awal')) {

            $query->whereDate(
                'tanggal_spt',
                '>=',
                $request->tanggal_awal
            );

        }


        if ($request->filled('tanggal_akhir')) {

            $query->whereDate(
                'tanggal_spt',
                '<=',
                $request->tanggal_akhir
            );

        }


        $registers = $query
            ->latest()
            ->get();


        $irbans = Irban::orderBy(
            'nama_irban'
        )->get();


        $jenisDokumen = RegisterNomorLhp::jenisDokumen();


        return view(
            'pages.register-lhp.index',
            compact(
                'registers',
                'irbans',
                'jenisDokumen'
            )
        );
    }



    /**
     * Simpan register dokumen
     */
    public function store(Request $request)
    {

        $request->validate([

            'irban_id' => [
                'required',
                'exists:irban,id'
            ],

            'jenis_dokumen' => [
                'required',
                'in:LHP,LHR,LHE,LHM,LHK,LHA'
            ],

            'nomor_dokumen' => [
                'required',
                'unique:register_nomor_lhp,nomor_dokumen'
            ],

            'nomor_spt' => [
                'required'
            ],

            'tanggal_spt' => [
                'required',
                'date'
            ],

            'tahun_pemeriksaan' => [
                'required'
            ],

            'anggaran_pemeriksaan' => [
                'nullable'
            ],

            'objek_pemeriksaan' => [
                'required'
            ],

            'dana_diawasi' => [
                'nullable'
            ],

            'nama_pimpinan' => [
                'required'
            ],

            'temuan' => [
                'nullable'
            ],

        ]);



        RegisterNomorLhp::create([

            'irban_id' => $request->irban_id,

            'jenis_dokumen' => $request->jenis_dokumen,

            'nomor_dokumen' => $request->nomor_dokumen,

            'nomor_spt' => $request->nomor_spt,

            'tanggal_spt' => $request->tanggal_spt,

            'tahun_pemeriksaan' => $request->tahun_pemeriksaan,

            'anggaran_pemeriksaan' => $this->formatNominal(
                $request->anggaran_pemeriksaan
            ),

            'objek_pemeriksaan' => $request->objek_pemeriksaan,

            'dana_diawasi' => $this->formatNominal(
                $request->dana_diawasi
            ),

            'nama_pimpinan' => $request->nama_pimpinan,

            'temuan' => $request->temuan,

        ]);



        return redirect()
            ->route('register-lhp.index')
            ->with(
                'success',
                'Register dokumen berhasil ditambahkan.'
            );
    }



    /**
     * Update register dokumen
     */
    public function update(Request $request, RegisterNomorLhp $registerLhp)
    {

        $request->validate([

            'irban_id' => 'required|exists:irban,id',

            'jenis_dokumen' => 'required|in:LHP,LHR,LHE,LHM,LHK,LHA',

            'nomor_dokumen' => [
                'required',
                'unique:register_nomor_lhp,nomor_dokumen,' . $registerLhp->id
            ],

            'nomor_spt' => 'required',

            'tanggal_spt' => 'required|date',

            'tahun_pemeriksaan' => 'required',

            'objek_pemeriksaan' => 'required',

            'nama_pimpinan' => 'required',

        ]);



        $registerLhp->update([

            'irban_id' => $request->irban_id,

            'jenis_dokumen' => $request->jenis_dokumen,

            'nomor_dokumen' => $request->nomor_dokumen,

            'nomor_spt' => $request->nomor_spt,

            'tanggal_spt' => $request->tanggal_spt,

            'tahun_pemeriksaan' => $request->tahun_pemeriksaan,

            'anggaran_pemeriksaan' => $this->formatNominal(
                $request->anggaran_pemeriksaan
            ),

            'objek_pemeriksaan' => $request->objek_pemeriksaan,

            'dana_diawasi' => $this->formatNominal(
                $request->dana_diawasi
            ),

            'nama_pimpinan' => $request->nama_pimpinan,

            'temuan' => $request->temuan,

        ]);



        return redirect()
            ->route('register-lhp.index')
            ->with(
                'success',
                'Register dokumen berhasil diperbarui.'
            );
    }




    /**
     * Hapus data
     */
    public function destroy(RegisterNomorLhp $registerLhp)
    {

        $registerLhp->delete();


        return redirect()
            ->route('register-lhp.index')
            ->with(
                'success',
                'Register dokumen berhasil dihapus.'
            );
    }



    /**
     * Format angka rupiah
     */
    private function formatNominal($value)
    {

        if (!$value) {
            return null;
        }


        return str_replace(
            '.',
            '',
            $value
        );
    }

}
