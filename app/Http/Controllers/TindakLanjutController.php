<?php

namespace App\Http\Controllers;

use App\Models\DokumenTindakLanjut;
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

        return view(
            "pages.tindak-lanjut.create",
            compact("rekomendasi", "statuses")
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

            "nilai_pengembalian" => "nullable",

            "nilai_setor_pajak" => "nullable",

            "tanggal_validasi" => "nullable",

            "validator" => "nullable",
        ]);

        $tindakLanjut = TindakLanjut::create([
            "rekomendasi_id" => $rekomendasi->id,

            "status_id" => $request->status_id,

            "narasi" => $request->narasi,

            "nilai_pengembalian" => $request->nilai_pengembalian
                ? str_replace(".", "", $request->nilai_pengembalian)
                : null,

            "nilai_setor_pajak" => $request->nilai_setor_pajak
                ? str_replace(".", "", $request->nilai_setor_pajak)
                : null,

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

        return view(
            "pages.tindak-lanjut.edit",
            compact("tindakLanjut", "statuses")
        );
    }

    /**
     * Update
     */
    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        $request->validate([
            "status_id" => "required",
            "narasi" => "required",
        ]);

        $tindakLanjut->update([
            "status_id" => $request->status_id,

            "narasi" => $request->narasi,

            "nilai_pengembalian" => $request->nilai_pengembalian
                ? str_replace(".", "", $request->nilai_pengembalian)
                : null,

            "nilai_setor_pajak" => $request->nilai_setor_pajak
                ? str_replace(".", "", $request->nilai_setor_pajak)
                : null,

            "tanggal_validasi" => $request->tanggal_validasi,

            "validator" => $request->validator,
        ]);

        // Upload dokumen tambahan

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

        return redirect()
            ->route("lhp.show", $tindakLanjut->rekomendasi->temuan->lhp_id)

            ->with("success", "Tindak lanjut berhasil diperbarui");
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

        $tindakLanjut->delete();

        return redirect()
            ->route("lhp.show", $lhp_id)

            ->with("success", "Tindak lanjut berhasil dihapus");
    }
}
