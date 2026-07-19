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

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Pilih Jenis Tindak Lanjut
                            </label>

                            <select name="jenis_tindak_lanjut" class="form-select" required>

                                <option value="Reguler"
                                    {{ old('jenis_tindak_lanjut', $tindakLanjut->jenis_tindak_lanjut ?? '') == 'Reguler' ? 'selected' : '' }}>
                                    Reguler
                                </option>

                                <option value="TPKD"
                                    {{ old('jenis_tindak_lanjut', $tindakLanjut->jenis_tindak_lanjut ?? '') == 'TPKD' ? 'selected' : '' }}>
                                    TPKD
                                </option>

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
                                placeholder="Contoh: 50.000.000,00 / Kosongkan jika tidak ada "
                                value="{{ number_format($tindakLanjut->nilai_pengembalian, 2, ',', '.') }}">


                        </div>






                        {{-- Nilai Pajak --}}

                        <div class="col-md-6 mb-3">


                            <label class="form-label">
                                Nilai Setor Pajak
                            </label>



                            <input type="text" name="nilai_setor_pajak" id="nilai_setor_pajak" class="form-control"
                                placeholder="Contoh: 50.000.000,00 / Kosongkan jika tidak ada "
                                value="{{ number_format($tindakLanjut->nilai_setor_pajak, 2, ',', '.') }}">


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
                                Dokumen Pendukung
                            </label>

                            {{-- Dokumen yang sudah ada --}}
                            @if ($tindakLanjut->dokumen->count())
                                <div class="mb-3">

                                    @foreach ($tindakLanjut->dokumen as $dokumen)
                                        <div
                                            class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

                                            <div>

                                                <a href="{{ asset('storage/' . $dokumen->path_file) }}" target="_blank">

                                                    <i class="bi bi-file-earmark"></i>

                                                    {{ $dokumen->nama_file }}

                                                </a>

                                            </div>

                                            <div>

                                                <label class="text-danger mb-0">

                                                    <input type="checkbox" name="hapus_dokumen[]"
                                                        value="{{ $dokumen->id }}">

                                                    Hapus

                                                </label>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="alert alert-light">
                                    Belum ada dokumen.
                                </div>
                            @endif


                            {{-- Upload dokumen baru --}}
                            <label class="form-label">
                                Tambah Dokumen Pendukung
                            </label>

                            <input type="file" name="dokumen[]" class="form-control" multiple>

                            <small class="text-muted">
                                File yang dipilih akan ditambahkan, bukan mengganti dokumen lama.
                            </small>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>

                            <textarea name="keterangan" class="form-control" rows="3">{{ $tindakLanjut->keterangan }}</textarea>
                        </div>



                    </div>


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
        const input = document.getElementById('nilai_pengembalian');
        const input = document.getElementById('nilai_setor_pajak');

        input.addEventListener('input', function() {

            let value = this.value;

            value = value.replace(/[^\d,]/g, '');

            const parts = value.split(',');

            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            this.value = parts.join(',');

        });
    </script>
@endsection
