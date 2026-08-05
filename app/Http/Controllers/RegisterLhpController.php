<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use App\Models\Lhp;
use Illuminate\Http\Request;

class RegisterLhpController extends Controller
{

    /**
     * Menampilkan Register No LHP
     */
    public function index(Request $request)
    {
        $jenis = $request->input('jenis', 'internal');
        $jenisLaporan = $request->input('jenis_laporan', 'LHP');

        $query = Lhp::with([
            'irban',
            'temuans.detailFinansial'
        ]);

        // User View hanya melihat Irban miliknya
        if (auth()->user()->isUserView()) {
            $query->where(
                'irban_id',
                auth()->user()->irban_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Jenis Pemeriksaan
    |--------------------------------------------------------------------------
    */

        if ($jenis == 'internal') {

            $query->where('instansi_pemeriksa', 'Itkab');
        } elseif ($jenis == 'eksternal') {

            $query->whereIn('instansi_pemeriksa', [
                'Itprov',
                'BPK RI',
                'BPKP'
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Jenis Laporan
    |--------------------------------------------------------------------------
    */

        if (!empty($jenisLaporan)) {
            $query->where('jenis_laporan', $jenisLaporan);
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Irban
    |--------------------------------------------------------------------------
    */

        if ($request->filled('irban_id')) {

            $query->where(
                'irban_id',
                $request->irban_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Tanggal
    |--------------------------------------------------------------------------
    */

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

        $lhps = $query
            ->orderBy('tanggal_spt', 'desc')
            ->get();

        $irbans = Irban::orderBy('nama_irban')->get();

        return view(
            'pages.register-lhp.index',
            compact(
                'lhps',
                'irbans',
                'jenis',
                'jenisLaporan'
            )
        );
    }



    /**
     * Cetak Register LHP
     */
    public function cetak(Request $request)
    {

        $query = Lhp::with([
            'irban',
            'temuans.detailFinansial'
        ]);


        /**
         * Filter Internal
         */
        if ($request->jenis == 'internal') {

            $query->where(
                'instansi_pemeriksa',
                'Itkab'
            );
        }


        /**
         * Filter Eksternal
         */
        elseif ($request->jenis == 'eksternal') {

            $query->whereIn(
                'instansi_pemeriksa',
                [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]
            );
        }



        /**
         * Filter Tim Pemeriksa
         */
        if ($request->filled('irban_id')) {

            $query->where(
                'irban_id',
                $request->irban_id
            );
        }



        /**
         * Filter tanggal
         */
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



        $lhps = $query
            ->orderBy(
                'tanggal_spt',
                'asc'
            )
            ->get();



        // tanda tangan
        $inspektur = \App\Models\Pegawai::where(
            'jabatan',
            'Inspektur Kabupaten Ketapang'
        )->first();



        return view(
            'pages.register-lhp.cetak',
            compact(
                'lhps',
                'inspektur'
            )
        );
    }
}
