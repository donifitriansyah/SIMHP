@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">


            <div>

                <h4 class="fw-bold mb-1">
                    Tambah Rekomendasi
                </h4>


                <p class="text-muted mb-0">
                    Tambah rekomendasi untuk Temuan Nomor {{ $temuan->nomor_temuan }}
                </p>

            </div>



            <a href="{{ route('lhp.show', $temuan->lhp_id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>


        </div>






        <form action="{{ route('rekomendasi.store', $temuan->id) }}" method="POST">

            @csrf




            <div class="card border-0 shadow-sm">



                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Form Rekomendasi
                    </h5>

                </div>




                <div class="card-body">


                    <div class="row">



                        {{-- Uraian Rekomendasi --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Uraian Rekomendasi
                            </label>


                            <textarea name="uraian_rekomendasi" class="form-control" rows="5" placeholder="Masukkan uraian rekomendasi"
                                required>{{ old('uraian_rekomendasi') }}</textarea>


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


                            <textarea name="administrasi" class="form-control" rows="4" placeholder="Masukkan rekomendasi administrasi">{{ old('administrasi') }}</textarea>


                        </div>








                        {{-- Nilai Finansial --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Finansial
                            </label>


                            <input type="text" name="nilai_finansial" id="nilai_finansial" class="form-control"
                                value="{{ old('nilai_finansial') }}" placeholder="Contoh: 50.000.000">


                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Kewajiban Setor Pajak
                            </label>


                            <input type="text" name="nilai_pajak" class="form-control uang"
                                value="{{ old('nilai_pajak') }}">

                        </div>



                    </div>



                </div>





                <div class="card-footer text-end">


                    <button type="submit" class="btn btn-primary">


                        <i class="bi bi-save"></i>

                        Simpan Rekomendasi


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

document.querySelectorAll('.uang').forEach(function(input){

    input.addEventListener('keyup', function(e){

        let value = this.value.replace(/\./g,'');

        this.value = new Intl.NumberFormat('id-ID')
            .format(value);

    });

});

</script>
@endsection
