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

                        <input type="text" class="form-control" value="Otomatis" hidden>


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

                        {{-- Jenis Detail Finansial --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Detail Temuan Finansial
                            </label>

                            <select name="jenis_finansial" id="jenis_finansial" class="form-select">

                                <option value="">
                                    Tidak Ada
                                </option>

                                <option value="pns">
                                    PNS
                                </option>

                                <option value="penyedia">
                                    Penyedia
                                </option>

                            </select>

                        </div>


                        {{-- Detail Finansial --}}
                        <div class="col-md-12" id="detail_finansial" style="display:none">


                            <div class="card border">

                                <div class="card-header bg-light">

                                    <strong>
                                        Detail Nilai Temuan
                                    </strong>

                                    <button type="button" class="btn btn-success btn-sm float-end" id="tambah_detail">

                                        <i class="bi bi-plus"></i>
                                        Tambah

                                    </button>

                                </div>


                                <div class="card-body">


                                    <div id="list_detail">


                                    </div>


                                </div>


                            </div>


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

        if (input) {

            input.addEventListener('input', function() {

                let value = this.value;

                value = value.replace(/[^\d]/g, '');

                this.value = value.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    '.'
                );

            });

        }



        document.addEventListener(
            'input',
            function(e) {

                if (
                    e.target.matches(
                        'input[name="detail_finansial[nilai][]"]'
                    )
                ) {

                    let value = e.target.value;

                    value = value.replace(/[^\d]/g, '');

                    e.target.value =
                        value.replace(
                            /\B(?=(\d{3})+(?!\d))/g,
                            '.'
                        );

                }

            }
        );

        let jenisFinansial = document.getElementById('jenis_finansial');

        let detailBox = document.getElementById('detail_finansial');

        let listDetail = document.getElementById('list_detail');

        let tombolTambah = document.getElementById('tambah_detail');



        jenisFinansial.addEventListener('change', function() {


            if (this.value) {

                detailBox.style.display = 'block';

                listDetail.innerHTML = '';

                tambahBaris();

            } else {

                detailBox.style.display = 'none';

                listDetail.innerHTML = '';

            }


        });




        tombolTambah.addEventListener('click', function() {

            tambahBaris();

        });





        function tambahBaris() {


            let jenis = jenisFinansial.value;


            let html = '';



            if (jenis === 'pns') {


                html = `

        <div class="row mb-3 detail-row">


            <div class="col-md-7">

                <label>
                    Nama PNS
                </label>

                <input type="text"
                    name="detail_finansial[nama_pihak][]"
                    class="form-control"
                    placeholder="Nama PNS">

            </div>



            <div class="col-md-4">

                <label>
                    Nilai Temuan
                </label>

                <input type="text"
                    name="detail_finansial[nilai][]"
                    class="form-control"
                    placeholder="Nilai">

            </div>



            <div class="col-md-1 d-flex align-items-end">

                <button type="button"
                    class="btn btn-danger hapus-detail">

                    <i class="bi bi-trash"></i>

                </button>

            </div>


        </div>

        `;



            } else if (jenis === 'penyedia') {


                html = `

        <div class="row mb-3 detail-row">


            <div class="col-md-7">


                <label>
                    Nama Penyedia
                </label>


                <input type="text"
                    name="detail_finansial[nama_penyedia][]"
                    class="form-control"
                    placeholder="Nama Penyedia">


            </div>



            <div class="col-md-4">


                <label>
                    Nilai Temuan
                </label>


                <input type="text"
                    name="detail_finansial[nilai][]"
                    class="form-control"
                    placeholder="Nilai">


            </div>



            <div class="col-md-1 d-flex align-items-end">


                <button type="button"
                    class="btn btn-danger hapus-detail">

                    <i class="bi bi-trash"></i>

                </button>


            </div>



        </div>

        `;


            }


            listDetail.insertAdjacentHTML(
                'beforeend',
                html
            );



        }





        document.addEventListener('click', function(e) {


            if (e.target.closest('.hapus-detail')) {


                e.target
                    .closest('.detail-row')
                    .remove();


            }


        });
    </script>
@endsection
