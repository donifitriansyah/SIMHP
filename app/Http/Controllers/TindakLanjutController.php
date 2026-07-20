<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DokumenTindakLanjut;
use App\Models\EditRequest;
use App\Models\Rekomendasi;
use App\Models\StatusTindakLanjut;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TindakLanjutController extends Controller
{
    /**
     * Form tambah tindak lanjut
     */
    public function create(Rekomendasi $rekomendasi)
    {
        $statuses = StatusTindakLanjut::all();


        // Load relasi tindak lanjut
        $rekomendasi->load('tindakLanjut');


        // Ambil tindak lanjut terakhir
        $terakhir = $rekomendasi->tindakLanjut
            ->sortByDesc('created_at')
            ->first();


        // Jika sudah selesai tidak boleh tambah lagi
        if ($terakhir && $terakhir->status_id == 3) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Tindak lanjut sudah selesai dan tidak dapat ditambahkan lagi.'
                );
        }


        return view(
            "pages.tindak-lanjut.create",
            compact(
                "rekomendasi",
                "statuses"
            )
        );
    }

    /**
     * Simpan tindak lanjut
     */
    public function store(Request $request, Rekomendasi $rekomendasi)
    {
        $request->validate([
            "status_id" => "required",
            "narasi" => "required",

            "nilai_pengembalian" => "nullable|string",
            "nilai_setor_pajak" => "nullable|string",

            "tanggal_validasi" => "nullable",
            "validator" => "nullable",

            'keterangan' => 'nullable|string',
        ]);


        $nilaiPengembalian = null;
        $nilaiSetorPajak = null;


        if ($request->filled('nilai_pengembalian')) {

            $nilaiPengembalian = str_replace(
                ['.', ','],
                ['', '.'],
                $request->nilai_pengembalian
            );
        }


        if ($request->filled('nilai_setor_pajak')) {

            $nilaiSetorPajak = str_replace(
                ['.', ','],
                ['', '.'],
                $request->nilai_setor_pajak
            );
        }


        $tindakLanjut = TindakLanjut::create([

            "rekomendasi_id" => $rekomendasi->id,

            "status_id" => $request->status_id,

            "keterangan" => $request->keterangan,

            "narasi" => $request->narasi,

            "nilai_pengembalian" => $nilaiPengembalian,

            "nilai_setor_pajak" => $nilaiSetorPajak,

            "tanggal_validasi" => $request->tanggal_validasi,

            "validator" => $request->validator,
        ]);


        if ($request->hasFile("dokumen")) {

            foreach ($request->file("dokumen") as $file) {

                $namaFile = time() . "_" . $file->getClientOriginalName();

                $path = $file->storeAs(
                    "dokumen-tindak-lanjut",
                    $namaFile,
                    "public"
                );


                DokumenTindakLanjut::create([

                    "tindak_lanjut_id" => $tindakLanjut->id,

                    "nama_file" => $file->getClientOriginalName(),

                    "path_file" => $path,

                    "tipe_file" => $file->getClientMimeType(),

                ]);
            }
        }


        $lhp = $rekomendasi->temuan->lhp;


        $lhp->updateStatusProses();

        $lhp->updateStatusLhp();

        ActivityLog::create([
                'user_id' => auth()->id(),
                'aksi' => 'Tambah',
                'modul' => 'Tindak Lanjut',
                'referensi_id' => $tindakLanjut->id,
                'deskripsi' => 'Mengedit Tindak Lanjut pada LHP ' . $tindakLanjut->rekomendasi->temuan->lhp->nomor_lhp,
            ]);


        return redirect()
            ->route("lhp.show", $rekomendasi->temuan->lhp_id)
            ->with("success", "Tindak lanjut berhasil ditambahkan");
    }

    /**
     * Form edit
     */
    public function edit(TindakLanjut $tindakLanjut)
    {
        $statuses = StatusTindakLanjut::all();

        $lhp = $tindakLanjut
            ->rekomendasi
            ->temuan
            ->lhp;


        if (!auth()->user()->canEditLhp($lhp)) {
            abort(403);
        }

        return view(
            "pages.tindak-lanjut.edit",
            compact("tindakLanjut", "statuses")
        );
    }

    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        $request->validate([
            'status_id' => 'required',
            'narasi' => 'required',

            'nilai_pengembalian' => 'nullable|string',
            'nilai_setor_pajak' => 'nullable|string',
        ]);


        $nilaiPengembalian = null;
        $nilaiSetorPajak = null;


        if ($request->filled('nilai_pengembalian')) {

            $nilaiPengembalian = str_replace(
                ['.', ','],
                ['', '.'],
                $request->nilai_pengembalian
            );
        }


        if ($request->filled('nilai_setor_pajak')) {

            $nilaiSetorPajak = str_replace(
                ['.', ','],
                ['', '.'],
                $request->nilai_setor_pajak
            );
        }


        $tindakLanjut->update([

            'status_id' => $request->status_id,

            'narasi' => $request->narasi,

            'keterangan' => $request->keterangan,

            'nilai_pengembalian' => $nilaiPengembalian,

            'nilai_setor_pajak' => $nilaiSetorPajak,

            'tanggal_validasi' => $request->tanggal_validasi,

            'validator' => $request->validator,

        ]);


        /*
    |--------------------------------------------------------------------------
    | Hapus Dokumen yang Dipilih
    |--------------------------------------------------------------------------
    */

        if ($request->filled('hapus_dokumen')) {

            $dokumen = DokumenTindakLanjut::whereIn(
                'id',
                $request->hapus_dokumen
            )->get();

            foreach ($dokumen as $file) {

                Storage::disk('public')->delete(
                    $file->path_file
                );

                $file->delete();
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Upload Dokumen Baru
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('dokumen')) {

            foreach ($request->file('dokumen') as $file) {

                $namaFile = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs(
                    'dokumen-tindak-lanjut',
                    $namaFile,
                    'public'
                );

                DokumenTindakLanjut::create([

                    'tindak_lanjut_id' => $tindakLanjut->id,

                    'nama_file' => $file->getClientOriginalName(),

                    'path_file' => $path,

                    'tipe_file' => $file->getClientMimeType(),

                ]);
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Update Status LHP
    |--------------------------------------------------------------------------
    */

        $lhp = $tindakLanjut->rekomendasi->temuan->lhp;

        $lhp->updateStatusProses();

        $lhp->updateStatusLhp();

        EditRequest::where('lhp_id', $tindakLanjut->rekomendasi->temuan->lhp_id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->update([
                'edit_tindak_lanjut' => true
            ]);

        ActivityLog::create([
                'user_id' => auth()->id(),
                'aksi' => 'Edit',
                'modul' => 'Tindak Lanjut',
                'referensi_id' => $tindakLanjut->id,
                'deskripsi' => 'Mengedit Tindak Lanjut pada LHP ' . $tindakLanjut->rekomendasi->temuan->lhp->nomor_lhp,
            ]);


        return redirect()
            ->route('lhp.show', $lhp->id)
            ->with(
                'success',
                'Tindak lanjut berhasil diperbarui.'
            );
    }

    public function destroy(TindakLanjut $tindakLanjut)
    {
        $lhp_id = $tindakLanjut->rekomendasi->temuan->lhp_id;

        // hapus dokumen terkait

        foreach ($tindakLanjut->dokumen as $dokumen) {
            if (Storage::disk("public")->exists($dokumen->path_file)) {
                Storage::disk("public")->delete($dokumen->path_file);
            }

            $dokumen->delete();
        }

        $lhp = $tindakLanjut->rekomendasi->temuan->lhp;

        $tindakLanjut->delete();

        $lhp->updateStatusProses();
        $lhp->updateStatusLhp();

        return redirect()
            ->route("lhp.show", $lhp_id)

            ->with("success", "Tindak lanjut berhasil dihapus");
    }
}
