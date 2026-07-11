@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">


            <div>

                <h4 class="fw-bold mb-1">
                    Edit Tindak Lanjut
                </h4>

                <p class="text-muted mb-0">
                    Perbarui data tindak lanjut rekomendasi
                </p>

            </div>



            <a href="{{ route('lhp.show', $tindakLanjut->rekomendasi->temuan->lhp_id) }}" class="btn btn-secondary">


                <i class="bi bi-arrow-left"></i>
                Kembali


            </a>


        </div>





        <form action="{{ route('tindak-lanjut.update', $tindakLanjut->id) }}" method="POST" enctype="multipart/form-data">


            @csrf
            @method('PUT')



            <div class="card border-0 shadow-sm">


                <div class="card-header bg-warning">


                    <h5 class="mb-0">
                        Form Edit Tindak Lanjut
                    </h5>


                </div>





                <div class="card-body">


                    <div class="row">



                        {{-- Status --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Status Tindak Lanjut
                            </label>


                            <select name="status_id" class="form-select" required>


                                <option value="">
                                    Pilih Status
                                </option>



                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ $tindakLanjut->status_id == $status->id ? 'selected' : '' }}>


                                        {{ $status->kode }} -
                                        {{ $status->nama_status }}


                                    </option>
                                @endforeach


                            </select>


                        </div>






                        {{-- Validator --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Validator
                            </label>


                            <input type="text" name="validator" class="form-control"
                                value="{{ old('validator', $tindakLanjut->validator) }}">


                        </div>






                        {{-- Narasi --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Narasi Tindak Lanjut
                            </label>


                            <textarea name="narasi" class="form-control" rows="5" required>{{ old('narasi', $tindakLanjut->narasi) }}</textarea>


                        </div>






                        {{-- Nilai Pengembalian --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Pengembalian
                            </label>


                            <input type="text" name="nilai_pengembalian" id="nilai_pengembalian" class="form-control"
                                value="{{ number_format($tindakLanjut->nilai_pengembalian ?? 0, 0, ',', '.') }}">


                        </div>






                        {{-- Nilai Pajak --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Setor Pajak
                            </label>


                            <input type="text" name="nilai_setor_pajak" id="nilai_setor_pajak" class="form-control"
                                value="{{ number_format($tindakLanjut->nilai_setor_pajak ?? 0, 0, ',', '.') }}">


                        </div>







                        {{-- Tanggal Validasi --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Tanggal Validasi
                            </label>


                            <input type="date" name="tanggal_validasi" class="form-control"
                                value="{{ $tindakLanjut->tanggal_validasi }}">


                        </div>





                        {{-- Upload Dokumen Tambahan --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Tambah Dokumen Pendukung
                            </label>


                            <input type="file" name="dokumen[]" class="form-control" multiple>


                        </div>



                    </div>


                </div>






                {{-- Dokumen Lama --}}

                <div class="card-footer">


                    <h6 class="fw-bold">
                        Dokumen Tersimpan
                    </h6>



                    <ul>


                        @forelse($tindakLanjut->dokumen as $dok)
                            <li>

                                <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank">


                                    {{ $dok->nama_file }}


                                </a>


                            </li>


                        @empty


                            <li class="text-muted">

                                Belum ada dokumen

                            </li>
                        @endforelse


                    </ul>


                </div>







                <div class="card-footer text-end">


                    <button type="submit" class="btn btn-warning">


                        <i class="bi bi-save"></i>

                        Update Tindak Lanjut


                    </button>


                </div>




            </div>




        </form>



    </div>





    <script>
        function formatRupiah(id) {

            let input = document.getElementById(id);


            input.addEventListener('keyup', function() {


                let value = this.value.replace(/\./g, '');


                if (value) {

                    this.value = new Intl.NumberFormat('id-ID')
                        .format(value);

                }


            });

        }



        formatRupiah('nilai_pengembalian');

        formatRupiah('nilai_setor_pajak');
    </script>
@endsection
