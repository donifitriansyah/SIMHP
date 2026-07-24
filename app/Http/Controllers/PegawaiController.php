<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use App\Models\Pegawai;
use App\Models\Skpd;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar pegawai
     */
    public function index()
    {
        $pegawais = Pegawai::with('skpd')
            ->orderBy('nama')
            ->get();

        $skpds = Skpd::orderBy('nama_skpd')->get();

        return view(
            'pages.master-data.pegawai.index',
            compact(
                'pegawais',
                'skpds'
            )
        );
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_pegawai.csv"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Nama',
                'NIP',
                'Jabatan',
                'Golongan',
                'SKPD'
            ]);


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:5120'
        ]);

        $path = $request->file('file')->getRealPath();

        $handle = fopen($path, 'r');

        if (!$handle) {
            return back()->with('error', 'File tidak dapat dibaca.');
        }

        // Lewati header
        fgetcsv($handle);

        $berhasil = 0;
        $update = 0;
        $gagal = 0;

        $errors = [];

        $baris = 2;

        while (($row = fgetcsv($handle, 1000, ",")) !== false) {

            if (count($row) < 5) {
                $errors[] = "Baris {$baris}: Format kolom tidak sesuai.";
                $gagal++;
                $baris++;
                continue;
            }

            $nama      = trim($row[0]);
            $nip       = trim($row[1]);
            $jabatan   = trim($row[2]);
            $golongan  = trim($row[3]);
            $namaSkpd  = trim($row[4]);

            if ($nama == '' || $nip == '') {
                $errors[] = "Baris {$baris}: Nama atau NIP kosong.";
                $gagal++;
                $baris++;
                continue;
            }

            $skpd = Skpd::where('nama_skpd', $namaSkpd)->first();

            if (!$skpd) {
                $errors[] = "Baris {$baris}: SKPD '{$namaSkpd}' tidak ditemukan.";
                $gagal++;
                $baris++;
                continue;
            }

            try {

                $pegawai = Pegawai::where('nip', $nip)->first();

                if ($pegawai) {

                    $pegawai->update([
                        'nama'      => $nama,
                        'jabatan'   => $jabatan,
                        'golongan'  => $golongan,
                        'skpd_id'   => $skpd->id,
                    ]);

                    $update++;
                } else {

                    Pegawai::create([
                        'nama'      => $nama,
                        'nip'       => $nip,
                        'jabatan'   => $jabatan,
                        'golongan'  => $golongan,
                        'skpd_id'   => $skpd->id,
                    ]);

                    $berhasil++;
                }
            } catch (\Exception $e) {

                $errors[] = "Baris {$baris}: " . $e->getMessage();
                $gagal++;
            }

            $baris++;
        }

        fclose($handle);

        return redirect()
            ->route('pegawai.index')
            ->with([
                'success' => "Import selesai. Data baru: {$berhasil}, Update: {$update}, Gagal: {$gagal}",
                'import_errors' => $errors
            ]);
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
            'skpd_id'   => 'nullable|exists:skpd,id',
        ], [
            'nama.required'     => 'Nama pegawai wajib diisi.',
            'nip.required'      => 'NIP wajib diisi.',
            'nip.unique'        => 'NIP sudah digunakan.',
            'jabatan.required'  => 'Jabatan wajib diisi.',
            'skpd_id.exists'    => 'SKPD tidak ditemukan.',
        ]);

        Pegawai::create([
            'nama'      => $request->nama,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'golongan'  => $request->golongan,
            'skpd_id'   => $request->skpd_id,
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
            'skpd_id'   => 'nullable|exists:skpd,id',
        ], [
            'nama.required'     => 'Nama pegawai wajib diisi.',
            'nip.required'      => 'NIP wajib diisi.',
            'nip.unique'        => 'NIP sudah digunakan.',
            'jabatan.required'  => 'Jabatan wajib diisi.',
            'skpd_id.exists'    => 'SKPD tidak ditemukan.',
        ]);

        $pegawai->update([
            'nama'      => $request->nama,
            'nip'       => $request->nip,
            'jabatan'   => $request->jabatan,
            'golongan'  => $request->golongan,
            'skpd_id'   => $request->skpd_id,
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
