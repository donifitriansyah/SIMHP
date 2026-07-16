@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">


            <div>

                <h4 class="fw-bold mb-1">
                    Edit Temuan Pemeriksaan
                </h4>


                <p class="text-muted mb-0">
                    Perbarui data temuan LHP
                </p>

            </div>



            <a href="{{ route('lhp.show', $temuan->lhp_id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>


        </div>





        <form action="{{ route('temuan.update', $temuan->id) }}" method="POST">

            @csrf
            @method('PUT')



            <div class="card border-0 shadow-sm">


                <div class="card-header bg-warning">

                    <h5 class="mb-0">
                        Form Edit Temuan
                    </h5>

                </div>




                <div class="card-body">


                    <div class="row">



                        {{-- Nomor Temuan --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nomor Temuan
                            </label>


                            <input type="number" name="nomor_temuan" class="form-control"
                                value="{{ old('nomor_temuan', $temuan->nomor_temuan) }}" required>


                        </div>






                        {{-- Nama Pelaku --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nama Pelaku
                            </label>


                            <input type="text" name="nama_pelaku" class="form-control"
                                value="{{ old('nama_pelaku', $temuan->nama_pelaku) }}" placeholder="Nama pelaku (opsional)">


                        </div>






                        {{-- Uraian Temuan --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Uraian Temuan
                            </label>


                            <textarea name="uraian_temuan" class="form-control" rows="4" required>{{ old('uraian_temuan', $temuan->uraian_temuan) }}</textarea>


                        </div>







                        {{-- Administrasi --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Temuan Administrasi
                            </label>


                            <textarea name="administrasi" class="form-control" rows="4">{{ old('administrasi', $temuan->administrasi) }}</textarea>


                        </div>








                        {{-- Nilai Kerugian --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Kerugian
                            </label>



                            <input type="text" name="nilai_kerugian" id="nilai_kerugian" class="form-control"
                                placeholder="Contoh: 50.000.000 / Kosongkan jika tidak ada kerugian"
                                value="{{ number_format($temuan->nilai_kerugian, 2, ',', '.') }}">


                        </div>



                    </div>


                </div>





                <div class="card-footer text-end">


                    <button type="submit" class="btn btn-warning">


                        <i class="bi bi-save"></i>

                        Update Temuan


                    </button>


                </div>



            </div>



        </form>



    </div>





    <script>
        const input = document.getElementById('nilai_kerugian');

        input.addEventListener('input', function() {

            let value = this.value;

            value = value.replace(/[^\d,]/g, '');

            const parts = value.split(',');

            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            this.value = parts.join(',');

        });
    </script>
@endsection
