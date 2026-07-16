@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Tambah Temuan Pemeriksaan
                </h4>

                <p class="text-muted mb-0">
                    Input temuan untuk LHP Nomor {{ $lhp->nomor_lhp }}
                </p>
            </div>


            <a href="{{ route('lhp.show', $lhp->id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>





        <form action="{{ route('temuan.store', $lhp->id) }}" method="POST">

            @csrf



            <div class="card border-0 shadow-sm">


                <div class="card-header bg-danger text-white">

                    <h5 class="mb-0">
                        Form Temuan
                    </h5>

                </div>



                <div class="card-body">


                    <div class="row">



                        {{-- Nomor Temuan --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nomor Temuan
                            </label>


                            <input type="number" name="nomor_temuan"
                                class="form-control @error('nomor_temuan') is-invalid @enderror"
                                value="{{ old('nomor_temuan') }}" placeholder="Contoh: 1" required>



                            @error('nomor_temuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>





                        {{-- Nama Pelaku --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nama Pelaku
                            </label>


                            <input type="text" name="nama_pelaku" class="form-control" value="{{ old('nama_pelaku') }}"
                                placeholder="Nama pelaku (opsional)">


                        </div>





                        {{-- Uraian Temuan --}}

                        <div class="col-md-12 mb-3">


                            <label class="form-label">
                                Uraian Temuan
                            </label>


                            <textarea name="uraian_temuan" class="form-control" rows="4" placeholder="Masukkan narasi temuan" required>{{ old('uraian_temuan') }}</textarea>


                        </div>






                        {{-- Administrasi --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Temuan Administrasi
                            </label>


                            <textarea name="administrasi" class="form-control" rows="4" placeholder="Masukkan temuan administrasi">{{ old('administrasi') }}</textarea>


                        </div>







                        {{-- Nilai Kerugian --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Kerugian
                            </label>


                            <input type="text" name="nilai_kerugian" id="nilai_kerugian" class="form-control"
                                value="{{ old('nilai_kerugian') }}"
                                placeholder="Contoh: 50.000.000 / Kosongkan jika tidak ada kerugian">


                        </div>



                    </div>


                </div>




                <div class="card-footer text-end">


                    <button type="submit" class="btn btn-primary">


                        <i class="bi bi-save"></i>

                        Simpan Temuan


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
