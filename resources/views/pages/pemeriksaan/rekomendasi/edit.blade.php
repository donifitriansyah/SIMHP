@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">


            <div>

                <h4 class="fw-bold mb-1">
                    Edit Rekomendasi
                </h4>


                <p class="text-muted mb-0">
                    Perbarui rekomendasi Temuan Nomor {{ $rekomendasi->temuan->nomor_temuan }}
                </p>

            </div>




            <a href="{{ route('lhp.show', $rekomendasi->temuan->lhp_id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>


        </div>







        <form action="{{ route('rekomendasi.update', $rekomendasi->id) }}" method="POST">


            @csrf
            @method('PUT')





            <div class="card border-0 shadow-sm">



                <div class="card-header bg-warning">


                    <h5 class="mb-0">
                        Form Edit Rekomendasi
                    </h5>


                </div>






                <div class="card-body">


                    <div class="row">





                        {{-- Uraian Rekomendasi --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Uraian Rekomendasi
                            </label>



                            <textarea name="uraian_rekomendasi" class="form-control" rows="5" required>{{ old('uraian_rekomendasi', $rekomendasi->uraian_rekomendasi) }}</textarea>


                            @error('uraian_rekomendasi')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>








                        {{-- Administrasi --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Rekomendasi Administrasi
                            </label>



                            <textarea name="administrasi" class="form-control" rows="4">{{ old('administrasi', $rekomendasi->administrasi) }}</textarea>



                        </div>









                        {{-- Nilai Finansial --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Finansial
                            </label>




                            <input type="text" name="nilai_finansial" id="nilai_finansial" class="form-control"
                                value="{{ $rekomendasi->nilai_finansial ? number_format($rekomendasi->nilai_finansial, 0, ',', '.') : '' }}">



                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Kewajiban Setor Pajak
                            </label>


                            <input type="text" name="nilai_pajak" class="form-control uang"
                                value="{{ old('nilai_pajak', $rekomendasi->nilai_pajak ?? '') }}">

                        </div>





                    </div>



                </div>






                <div class="card-footer text-end">


                    <button type="submit" class="btn btn-warning">


                        <i class="bi bi-save"></i>

                        Update Rekomendasi


                    </button>


                </div>




            </div>





        </form>



    </div>







    <script>
        document
            .getElementById('nilai_finansial')
            .addEventListener('keyup', function() {


                let value = this.value.replace(/\./g, '');



                if (value) {


                    this.value = new Intl.NumberFormat('id-ID')
                        .format(value);


                }


            });
    </script>
    <script>
        document.querySelectorAll('.uang').forEach(function(input) {

            input.addEventListener('keyup', function(e) {

                let value = this.value.replace(/\./g, '');

                this.value = new Intl.NumberFormat('id-ID')
                    .format(value);

            });

        });
    </script>
@endsection
