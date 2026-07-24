<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Irban;
use App\Models\Lhp;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'internal';

        $user = auth()->user();

        $filterLhp = function ($query) use ($jenis, $user) {

            if ($jenis == 'internal') {
                $query->where('instansi_pemeriksa', 'Itkab');
            } else {
                $query->whereIn('instansi_pemeriksa', [
                    'Itprov',
                    'BPK RI',
                    'BPKP'
                ]);
            }

            // User View hanya melihat Irban miliknya
            if ($user->isUserView()) {
                $query->where('irban_id', $user->irban_id);
            }
        };

        $lhpQuery = Lhp::query();

        $filterLhp($lhpQuery);

        $totalLhp = (clone $lhpQuery)->count();

        $totalTemuan = Temuan::whereHas('lhp', $filterLhp)->count();

        $totalRekomendasi = Rekomendasi::whereHas(
            'temuan.lhp',
            $filterLhp
        )->count();

        $totalTindakLanjut = TindakLanjut::whereHas(
            'rekomendasi.temuan.lhp',
            $filterLhp
        )->count();

        $totalPengembalian = TindakLanjut::whereHas(
            'rekomendasi.temuan.lhp',
            $filterLhp
        )->sum('nilai_pengembalian');

        $belumDitindaklanjuti = (clone $lhpQuery)
    ->where('status_proses', 'belum_diproses')
    ->count();

        $statusLhp = [

            'selesai' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'selesai'
                )
                ->count(),


            'dalam_proses' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'dalam_proses'
                )
                ->count(),


            'belum_proses' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'belum_diproses'
                )
                ->count(),


            'nihil' => (clone $lhpQuery)
                ->where(
                    'status_proses',
                    'nihil'
                )
                ->count(),

        ];

        $totalKerugian = Rekomendasi::whereHas(
            'temuan.lhp',
            $filterLhp
        )->sum('nilai_finansial');

        $queryIrban = Irban::with('lhps.temuans');

        if ($user->isUserView()) {
            $queryIrban->where('id', $user->irban_id);
        }

        $temuanIrban = $queryIrban->get()
            ->map(function ($irban) use ($jenis) {

                $total = $irban->lhps
                    ->filter(function ($lhp) use ($jenis) {

                        if ($jenis == 'internal') {
                            return $lhp->instansi_pemeriksa == 'Itkab';
                        }

                        return in_array($lhp->instansi_pemeriksa, [
                            'Itprov',
                            'BPK RI',
                            'BPKP'
                        ]);
                    })
                    ->sum(fn($lhp) => $lhp->temuans->count());

                return [
                    'nama' => $irban->nama_irban,
                    'total' => $total
                ];
            });

        $dataKerugian = [

            'total' => $totalKerugian,

            'dikembalikan' => $totalPengembalian,

            'sisa' =>
            $totalKerugian - $totalPengembalian

        ];

        $sisaKerugian = $totalKerugian - $totalPengembalian;

        $aktivitas = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view(
            'dashboard',
            compact(
                'totalLhp',
                'totalTemuan',
                'totalRekomendasi',
                'totalTindakLanjut',
                'statusLhp',
                'totalKerugian',
                'totalPengembalian',
                'aktivitas',
                'temuanIrban',
                'dataKerugian',
                'jenis',
                'belumDitindaklanjuti',
                'sisaKerugian'
            )
        );
    }
}
