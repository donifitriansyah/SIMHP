<?php

namespace App\Http\Controllers;

use App\Models\Irban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IrbanController extends Controller
{

    /**
     * Menampilkan data Irban
     */
    public function index()
    {

        $irbans = Irban::latest()->get();


        return view(
            'pages.master-data.irban.index',
            compact('irbans')
        );
    }



    /**
     * Simpan data Irban
     */
    public function store(Request $request)
    {
        $request->validate([

            'kode' => [
                'required',
                'unique:irban,kode'
            ],

            'nama_irban' => [
                'required'
            ],

            'nama_inspektur_pembantu' => [
                'nullable',
                'string',
                'max:150'
            ]

        ]);

        try {
            DB::beginTransaction();
            Irban::create([
                'kode' => $request->kode,
                'nama_irban' => $request->nama_irban,
                'nama_inspektur_pembantu' => $request->nama_inspektur_pembantu,
                'status' => 1
            ]);

            DB::commit();

            return redirect()
                ->route('irban.index')
                ->with(
                    'success',
                    'Data Irban berhasil ditambahkan.'
                );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(
                'Gagal tambah Irban : ' . $e->getMessage()
            );
            return back()

                ->withInput()

                ->with(
                    'error',
                    'Data Irban gagal ditambahkan. ' . $e->getMessage()
                );
        }
    }

    /**
     * Update data Irban
     */
    public function update(Request $request, Irban $irban)
    {

        $request->validate([

            'kode' => [
                'required',
                'string',
                'max:20',
                'unique:irban,kode,' . $irban->id
            ],


            'nama_irban' => [
                'required',
                'string',
                'max:100'
            ],


            'nama_inspektur_pembantu' => [
                'nullable',
                'string',
                'max:150'
            ],


            'status' => [
                'required',
                'boolean'
            ]

        ]);



        try {


            $irban->update([

                'kode' => $request->kode,

                'nama_irban' => $request->nama_irban,

                'nama_inspektur_pembantu' =>
                $request->nama_inspektur_pembantu,

                'status' => $request->status,


            ]);



            return redirect()

                ->route('irban.index')

                ->with(

                    'success',

                    'Data Irban berhasil diperbarui.'

                );
        } catch (\Exception $e) {


            Log::error(

                'Gagal update Irban : ' . $e->getMessage()

            );



            return back()

                ->withInput()

                ->with(

                    'error',

                    'Data Irban gagal diperbarui. Silakan coba lagi.'

                );
        }
    }

    /**
     * Hapus data Irban
     */
    public function destroy(Irban $irban)
    {
        try {
            $irban->delete();
            return redirect()
                ->route('irban.index')
                ->with(
                    'success',
                    'Data Irban berhasil dihapus.'
                );
        } catch (\Exception $e) {
            Log::error(
                'Gagal hapus Irban : ' . $e->getMessage()
            );
            return back()
                ->with(
                    'error',
                    'Data Irban gagal dihapus. ' . $e->getMessage()
                );
        }
    }
}
