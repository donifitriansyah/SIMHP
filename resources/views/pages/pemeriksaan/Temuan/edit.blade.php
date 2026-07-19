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

                        @php
                            $jenis = $temuan->detailFinansial->first()->jenis ?? '';
                        @endphp
                        {{-- Jenis Detail Finansial --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Detail Temuan Finansial
                            </label>

                            <select name="jenis_finansial" id="jenis_finansial" class="form-select">

                                <option value="">Tidak Ada</option>

                                <option value="pns" {{ $jenis == 'pns' ? 'selected' : '' }}>
                                    PNS
                                </option>

                                <option value="penyedia" {{ $jenis == 'penyedia' ? 'selected' : '' }}>
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

                                        @foreach ($temuan->detailFinansial as $detail)
                                            <div class="row mb-3 detail-row">

                                                @if ($detail->jenis == 'pns')
                                                    <div class="col-md-7">

                                                        <label>Nama PNS</label>

                                                        <input type="text" name="detail_finansial[nama_pihak][]"
                                                            class="form-control" value="{{ $detail->nama_pihak }}">

                                                    </div>
                                                @else
                                                    <div class="col-md-7">

                                                        <label>Nama Penyedia</label>

                                                        <input type="text" name="detail_finansial[nama_penyedia][]"
                                                            class="form-control" value="{{ $detail->nama_penyedia }}">

                                                    </div>
                                                @endif

                                                <div class="col-md-4">

                                                    <label>Nilai Temuan</label>

                                                    <input type="text" name="detail_finansial[nilai][]"
                                                        class="form-control"
                                                        value="{{ number_format($detail->nilai_temuan, 0, ',', '.') }}">

                                                </div>

                                                <div class="col-md-1 d-flex align-items-end">

                                                    <button type="button" class="btn btn-danger hapus-detail">

                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>


                                </div>


                            </div>


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


        if (jenisFinansial.value !== '') {

            detailBox.style.display = 'block';

        }
        jenisFinansial.addEventListener('change', function() {


            if (this.value) {

                detailBox.style.display = 'block';

                jenisFinansial.addEventListener('change', function() {

                    detailBox.style.display = this.value ? 'block' : 'none';

                });

                tambahBaris();

            } else {

                detailBox.style.display = 'none';

                jenisFinansial.addEventListener('change', function() {

                    detailBox.style.display = this.value ? 'block' : 'none';

                });

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
