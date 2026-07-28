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
                            $jenis = old('jenis_finansial', $temuan->detailFinansial->first()?->jenis);
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

                                <option value="perangkat_desa" {{ $jenis == 'perangkat_desa' ? 'selected' : '' }}>
                                    Perangkat Desa
                                </option>

                                <option value="penyedia" {{ $jenis == 'penyedia' ? 'selected' : '' }}>
                                    Penyedia
                                </option>

                                <option value="pihak_lain" {{ $jenis == 'pihak_lain' ? 'selected' : '' }}>
                                    Pihak Lain
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

                                        @foreach ($temuan->detailFinansial->where('jenis', $jenis) as $detail)
                                            <div class="row mb-3 detail-row">

                                                @if ($detail->jenis == 'pns')
                                                    <div class="col-md-7">

                                                        <label>Pegawai</label>

                                                        <select name="detail_finansial[pegawai_id][]" class="form-select">

                                                            <option value="">Pilih Pegawai</option>

                                                            @foreach ($pegawais as $pegawai)
                                                                <option value="{{ $pegawai->id }}"
                                                                    {{ $detail->pegawai_id == $pegawai->id ? 'selected' : '' }}>

                                                                    {{ $pegawai->nama }}

                                                                    @if ($pegawai->skpd)
                                                                        - {{ $pegawai->skpd->nama_skpd }}
                                                                    @endif

                                                                </option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                @elseif ($detail->jenis == 'perangkat_desa')
                                                    <div class="col-md-7">

                                                        <label>Perangkat Desa</label>

                                                        <select name="detail_finansial[perangkat_desa_id][]"
                                                            class="form-select">

                                                            <option value="">
                                                                Pilih Perangkat Desa
                                                            </option>

                                                            @foreach ($perangkatDesas as $desa)
                                                                <option value="{{ $desa->id }}"
                                                                    {{ $detail->perangkat_desa_id == $desa->id ? 'selected' : '' }}>

                                                                    {{ $desa->nama }}

                                                                </option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                @elseif ($detail->jenis == 'penyedia')
                                                    <div class="col-md-7">

                                                        <label>Penyedia</label>

                                                        <select name="detail_finansial[pihak_ketiga_id][]"
                                                            class="form-select">

                                                            <option value="">
                                                                Pilih Penyedia
                                                            </option>

                                                            @foreach ($pihakKetigas as $pihak)
                                                                <option value="{{ $pihak->id }}"
                                                                    {{ $detail->pihak_ketiga_id == $pihak->id ? 'selected' : '' }}>

                                                                    {{ $pihak->nama_perusahaan }}

                                                                </option>
                                                            @endforeach

                                                        </select>

                                                    </div>
                                                @elseif ($detail->jenis == 'pihak_lain')
                                                    <div class="col-md-7">

                                                        <label>Pihak Lain</label>

                                                        <select name="detail_finansial[pihak_lain_id][]"
                                                            class="form-select">

                                                            <option value="">
                                                                Pilih Pihak Lain
                                                            </option>

                                                            @foreach ($pihakLains as $pihak)
                                                                <option value="{{ $pihak->id }}"
                                                                    {{ $detail->pihak_lain_id == $pihak->id ? 'selected' : '' }}>

                                                                    {{ $pihak->nama }}

                                                                </option>
                                                            @endforeach

                                                        </select>

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
        const pegawais = @json($pegawais);
        const pihakKetigas = @json($pihakKetigas);
        const perangkatDesas = @json($perangkatDesas);
        const pihakLains = @json($pihakLains);
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


        document.addEventListener('DOMContentLoaded', function() {

            if (jenisFinansial.value !== '') {

                detailBox.style.display = 'block';

            }

        });
        tombolTambah.addEventListener('click', function() {

    tambahBaris();

});
        jenisFinansial.addEventListener('change', function() {

            detailBox.style.display = this.value ?
                'block' :
                'none';


            listDetail.innerHTML = '';


            if (this.value) {

                tambahBaris();

            }

        });

        tombolTambah.addEventListener('click', function() {

            tambahBaris();

        });

        function tambahBaris() {

            let jenis = jenisFinansial.value;

            let html = '';

            if (jenis === 'pns') {

                let optionPegawai = '<option value="">Pilih Pegawai</option>';

                pegawais.forEach(function(item) {

                    optionPegawai += `
                <option value="${item.id}">
                    ${item.nama}
                    ${item.skpd ? '- '+item.skpd.nama_skpd : ''}
                </option>
            `;

                });


                html = `
        <div class="row mb-3 detail-row">

            <div class="col-md-7">
                <label>Pegawai</label>

                <select
                    name="detail_finansial[pegawai_id][]"
                    class="form-select">

                    ${optionPegawai}

                </select>

            </div>


            <div class="col-md-4">

                <label>Nilai Temuan</label>

                <input
                    type="text"
                    name="detail_finansial[nilai][]"
                    class="form-control">

            </div>


            <div class="col-md-1 d-flex align-items-end">

                <button type="button"
                    class="btn btn-danger hapus-detail">
                    <i class="bi bi-trash"></i>
                </button>

            </div>

        </div>
        `;

            } else if (jenis === 'perangkat_desa') {


                let optionDesa = '<option value="">Pilih Perangkat Desa</option>';


                perangkatDesas.forEach(function(item) {

                    optionDesa += `
                <option value="${item.id}">
                    ${item.nama}
                </option>
            `;

                });



                html = `
        <div class="row mb-3 detail-row">

            <div class="col-md-7">

                <label>Perangkat Desa</label>

                <select
                    name="detail_finansial[perangkat_desa_id][]"
                    class="form-select">

                    ${optionDesa}

                </select>

            </div>


            <div class="col-md-4">

                <label>Nilai Temuan</label>

                <input
                type="text"
                name="detail_finansial[nilai][]"
                class="form-control">

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


                let optionPihak = '<option value="">Pilih Penyedia</option>';


                pihakKetigas.forEach(function(item) {

                    optionPihak += `
                <option value="${item.id}">
                    ${item.nama_perusahaan}
                </option>
            `;

                });


                html = `
        <div class="row mb-3 detail-row">

            <div class="col-md-7">

                <label>Penyedia</label>

                <select
                name="detail_finansial[pihak_ketiga_id][]"
                class="form-select">

                    ${optionPihak}

                </select>

            </div>


            <div class="col-md-4">

                <label>Nilai Temuan</label>

                <input
                type="text"
                name="detail_finansial[nilai][]"
                class="form-control">

            </div>


            <div class="col-md-1 d-flex align-items-end">

                <button type="button"
                class="btn btn-danger hapus-detail">

                <i class="bi bi-trash"></i>

                </button>

            </div>

        </div>
        `;


            } else if (jenis === 'pihak_lain') {


                let optionLain = '<option value="">Pilih Pihak Lain</option>';


                pihakLains.forEach(function(item) {

                    optionLain += `
                <option value="${item.id}">
                    ${item.nama}
                </option>
            `;

                });


                html = `
        <div class="row mb-3 detail-row">

            <div class="col-md-7">

                <label>Pihak Lain</label>

                <select
                name="detail_finansial[pihak_lain_id][]"
                class="form-select">

                    ${optionLain}

                </select>

            </div>


            <div class="col-md-4">

                <label>Nilai Temuan</label>

                <input
                type="text"
                name="detail_finansial[nilai][]"
                class="form-control">

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
