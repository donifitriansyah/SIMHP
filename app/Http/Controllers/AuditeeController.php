<?php

namespace App\Http\Controllers;

use App\Models\Auditee;
use App\Models\PejabatAuditee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AuditeeController extends Controller
{


    /**
     * Menampilkan data auditee
     */
    public function index()
    {

        $auditees = Auditee::with('pejabat')
            ->latest()
            ->get();


        return view(
            'pages.master-data.auditee.index',
            compact('auditees')
        );
    }



    /**
     * Simpan data auditee
     */
    public function store(Request $request)
    {


        $request->validate([

            'nama_dinas' => [
                'required',
                'string',
                'max:150'
            ],


            'alamat' => [
                'required',
                'string'
            ],


            'pejabat' => [
                'nullable',
                'array'
            ]

        ]);



        DB::beginTransaction();


        try {


            // Simpan auditee

            $auditee = Auditee::create([

                'nama_dinas' => $request->nama_dinas,

                'alamat' => $request->alamat

            ]);




            // Simpan pejabat

            if ($request->pejabat) {


                foreach ($request->pejabat as $item) {


                    if (!empty($item['nama'])) {


                        PejabatAuditee::create([

                            'auditee_id' => $auditee->id,

                            'jenis_jabatan' => $item['jenis_jabatan'],

                            'nama' => $item['nama'],

                            'tahun' => $item['tahun'] ?? null

                        ]);
                    }
                }
            }



            DB::commit();



            return redirect()

                ->route('auditee.index')

                ->with(
                    'success',
                    'Data Auditee berhasil ditambahkan.'
                );
        } catch (\Exception $e) {


            DB::rollBack();


            Log::error(
                'Gagal tambah Auditee : ' . $e->getMessage()
            );



            return back()

                ->withInput()

                ->with(
                    'error',
                    'Data Auditee gagal ditambahkan.'
                );
        }
    }





    /**
     * Detail data
     */
    public function show(Auditee $auditee)
    {

        $auditee->load('pejabat');


        return view(
            'pages.master-data.auditee.show',
            compact('auditee')
        );
    }






    /**
     * Update data auditee
     */
    public function update(Request $request, Auditee $auditee)
    {


        $request->validate([

            'nama_dinas' => [
                'required',
                'string',
                'max:150'
            ],


            'alamat' => [
                'required',
                'string'
            ],


            'pejabat' => [
                'nullable',
                'array'
            ]


        ]);



        DB::beginTransaction();



        try {



            // Update auditee

            $auditee->update([

                'nama_dinas' => $request->nama_dinas,

                'alamat' => $request->alamat

            ]);





            // Update pejabat

            if ($request->pejabat) {


                foreach ($request->pejabat as $item) {


                    if (isset($item['id'])) {


                        PejabatAuditee::where('id', $item['id'])

                            ->update([

                                'nama' => $item['nama'],

                                'tahun' => $item['tahun']

                            ]);
                    } else {


                        PejabatAuditee::create([

                            'auditee_id' => $auditee->id,

                            'jenis_jabatan' => $item['jenis_jabatan'],

                            'nama' => $item['nama'],

                            'tahun' => $item['tahun'] ?? null

                        ]);
                    }
                }
            }




            DB::commit();



            return redirect()

                ->route('auditee.index')

                ->with(
                    'success',
                    'Data Auditee berhasil diperbarui.'
                );
        } catch (\Exception $e) {


            DB::rollBack();



            Log::error(

                'Gagal update Auditee : ' . $e->getMessage()

            );



            return back()

                ->withInput()

                ->with(

                    'error',

                    'Data Auditee gagal diperbarui.'

                );
        }
    }






    /**
     * Hapus data auditee
     */
    public function destroy(Auditee $auditee)
    {


        DB::beginTransaction();


        try {


            // hapus pejabat dahulu

            PejabatAuditee::where(
                'auditee_id',
                $auditee->id
            )->delete();



            // hapus auditee

            $auditee->delete();



            DB::commit();



            return redirect()

                ->route('auditee.index')

                ->with(
                    'success',
                    'Data Auditee berhasil dihapus.'
                );
        } catch (\Exception $e) {


            DB::rollBack();



            Log::error(
                'Gagal hapus Auditee : ' . $e->getMessage()
            );



            return back()

                ->with(

                    'error',

                    'Data Auditee gagal dihapus.'

                );
        }
    }
}
