<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Irban;
use App\Models\Auditee;
use App\Models\PihakKetiga;
use App\Models\ObjekPemeriksaan;
use Illuminate\Http\Request;

class LhpController extends Controller
{

    // public function index()
    // {
    //     $lhps = Lhp::with([
    //         'irban',
    //         'auditee',
    //         'pihakKetiga',
    //         'objekPemeriksaan'
    //     ])
    //         ->latest()
    //         ->paginate(10);


    //     return view(
    //         'pages.pemeriksaan.lhp.index',
    //         compact('lhps')
    //     );
    // }

    public function tetapkanNihil(Lhp $lhp)
    {

        // pastikan belum ada temuan
        if ($lhp->temuans()->count() > 0) {

            return back()->with(
                'error',
                'LHP sudah memiliki temuan, tidak dapat ditetapkan sebagai nihil'
            );
        }



        $lhp->update([

            'status_proses' => 'nihil'

        ]);



        return back()->with(
            'success',
            'LHP berhasil ditetapkan sebagai Nihil'
        );
    }

    public function index()
    {
        $lhps = Lhp::with([
            'auditee',
            'objekPemeriksaan',
            'temuans.rekomendasis.tindakLanjut'
        ])
            ->withCount('temuans')
            ->latest()
            ->paginate(10);

        foreach ($lhps as $lhp) {

            $totalRekomendasi = 0;
            $totalSelesai = 0;


            foreach ($lhp->temuans as $temuan) {

                foreach ($temuan->rekomendasis as $rekomendasi) {

                    $totalRekomendasi++;


                    foreach ($rekomendasi->tindakLanjut as $tl) {

                        if (
                            $tl->status &&
                            $tl->status->kode == 'S'
                        ) {
                            $totalSelesai++;
                        }
                    }
                }
            }



            $lhp->totalRekomendasi = $totalRekomendasi;

            $lhp->totalSelesai = $totalSelesai;



            $lhp->progress = $totalRekomendasi > 0
                ? round(($totalSelesai / $totalRekomendasi) * 100)
                : 0;
        }

        $statistik = [

            'total' => Lhp::count(),

            'nihil' => Lhp::where(
                'status_proses',
                'nihil'
            )->count(),


            'belum_proses' => Lhp::where(
                'status_proses',
                'belum_diproses'
            )->count(),


            'dalam_proses' => Lhp::where(
                'status_proses',
                'dalam_proses'
            )->count(),


            'selesai' => Lhp::where(
                'status_proses',
                'selesai'
            )->count(),

        ];


        return view(
            'pages.pemeriksaan.lhp.index',
            compact('lhps','statistik')
        );
    }

    public function filter($status)
    {

        $query = Lhp::with([
            'auditee',
            'objekPemeriksaan',
            'temuans.rekomendasis.tindakLanjut'
        ]);


        switch ($status) {

            case 'nihil':

                $query->where('status_proses', 'nihil');

                break;



            case 'belum_proses':

                $query->where('status_proses', 'belum_diproses');

                break;



            case 'dalam_proses':

                $query->where('status_proses', 'dalam_proses');

                break;



            case 'selesai':

                $query->where('status_proses', 'selesai');

                break;
        }


        $lhps = $query->paginate(10);


        return view(
            'pages.pemeriksaan.LHP.index',
            compact('lhps')
        );
    }

    public function selesai(Lhp $lhp)
    {

        foreach ($lhp->temuans as $temuan) {

            if ($temuan->rekomendasis()->count() == 0) {

                return back()->with(
                    'error',
                    'Tidak dapat menyelesaikan LHP. Masih ada temuan tanpa rekomendasi.'
                );
            }
        }



        $lhp->update([

            'status_proses' => 'selesai'

        ]);


        $lhp->updateStatusLhp();


        return back()->with(
            'success',
            'LHP berhasil diselesaikan'
        );
    }

    public function create()
    {

        $irbans = Irban::all();

        $auditees = Auditee::all();

        $pihakKetigas = PihakKetiga::all();

        $objeks = ObjekPemeriksaan::all();


        return view(
            'pages.pemeriksaan.lhp.create',
            compact(
                'irbans',
                'auditees',
                'pihakKetigas',
                'objeks'
            )
        );
    }

    public function store(Request $request)
    {

        $request->validate([

            'irban_id' => 'required',
            'auditee_id' => 'required',
            'objek_pemeriksaan_id' => 'required',

            'nomor_lhp' => 'required',
            'tanggal_lhp' => 'required|date',

            'nomor_spt' => 'required',
            'tanggal_spt' => 'required|date',

            'tahun_pkpt' => 'required',

            'jenis_pemeriksaan' => 'required'

        ]);

        Lhp::create([

            'irban_id' => $request->irban_id,

            'auditee_id' => $request->auditee_id,

            'pihak_ketiga_id' => $request->pihak_ketiga_id,

            'objek_pemeriksaan_id' => $request->objek_pemeriksaan_id,


            'nomor_lhp' => $request->nomor_lhp,

            'tanggal_lhp' => $request->tanggal_lhp,


            'nomor_spt' => $request->nomor_spt,

            'tanggal_spt' => $request->tanggal_spt,


            'tahun_pkpt' => $request->tahun_pkpt,


            'jumlah_dana_diawasi' => str_replace(
                '.',
                '',
                $request->jumlah_dana_diawasi
            ),


            'jenis_pemeriksaan' => $request->jenis_pemeriksaan,


            'status_lhp' => 'tidak_lengkap'

        ]);
        return redirect()
            ->route('lhp.index')
            ->with(
                'success',
                'Data LHP berhasil ditambahkan'
            );
    }

    public function show(Lhp $lhp)
    {

        $lhp->load([

            'irban',
            'auditee',
            'pihakKetiga',
            'objekPemeriksaan',
            'temuans.rekomendasis.tindakLanjut'

        ]);


        return view(
            'pages.pemeriksaan.lhp.show',
            compact('lhp')
        );
    }

    public function edit(Lhp $lhp)
    {

        $irbans = Irban::all();

        $auditees = Auditee::all();

        $pihakKetigas = PihakKetiga::all();

        $objeks = ObjekPemeriksaan::all();


        return view(
            'pages.pemeriksaan.lhp.edit',
            compact(
                'lhp',
                'irbans',
                'auditees',
                'pihakKetigas',
                'objeks'
            )
        );
    }

    public function update(Request $request, Lhp $lhp)
    {

        $request->validate([

            'irban_id' => 'required',
            'auditee_id' => 'required',
            'objek_pemeriksaan_id' => 'required',

            'nomor_lhp' => 'required',
            'tanggal_lhp' => 'required|date',

            'nomor_spt' => 'required',
            'tanggal_spt' => 'required|date',

            'tahun_pkpt' => 'required',

            'jenis_pemeriksaan' => 'required'

        ]);



        $lhp->update([

            'irban_id' => $request->irban_id,

            'auditee_id' => $request->auditee_id,

            'pihak_ketiga_id' => $request->pihak_ketiga_id,

            'objek_pemeriksaan_id' => $request->objek_pemeriksaan_id,


            'nomor_lhp' => $request->nomor_lhp,

            'tanggal_lhp' => $request->tanggal_lhp,


            'nomor_spt' => $request->nomor_spt,

            'tanggal_spt' => $request->tanggal_spt,


            'tahun_pkpt' => $request->tahun_pkpt,


            'jumlah_dana_diawasi' => str_replace(
                '.',
                '',
                $request->jumlah_dana_diawasi
            ),


            'jenis_pemeriksaan' => $request->jenis_pemeriksaan

        ]);



        return redirect()
            ->route('lhp.index')
            ->with(
                'success',
                'Data LHP berhasil diperbarui'
            );
    }





    public function destroy(Lhp $lhp)
    {

        $lhp->delete();


        return redirect()
            ->route('lhp.index')
            ->with(
                'success',
                'Data LHP berhasil dihapus'
            );
    }
}
