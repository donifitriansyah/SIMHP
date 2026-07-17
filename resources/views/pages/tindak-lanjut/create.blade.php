@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1"> Tambah Tindak Lanjut </h4>

                <p class="text-muted mb-0"> Input tindak lanjut rekomendasi </p>

            </div>

            <a href="{{ route('lhp.show', $rekomendasi->temuan->lhp_id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i> Kembali

            </a>

        </div>

        <form enctype="multipart/form-data" action="{{ route('tindak-lanjut.store', $rekomendasi->id) }}" method="POST">

            @csrf

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0"> Form Tindak Lanjut </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Status --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label"> Status Tindak Lanjut </label>

                            <select name="status_id" class="form-select" required>

                                <option value=""> Pilih Status </option>

                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ old('status_id') == $status->id ? 'selected' : '' }}>

                                        {{ $status->kode }} - {{ $status->nama_status }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3"> <label class="form-label"> Pilih Jenis Tindak Lanjut </label>

                            <select name="jenis_tindak_lanjut" class="form-select" required>

                                <option value="Reguler"
                                    {{ old('jenis_tindak_lanjut', $tindakLanjut->jenis_tindak_lanjut ?? '') == 'Reguler' ? 'selected' : '' }}>
                                    Reguler </option>

                                <option value="TPKD"
                                    {{ old('jenis_tindak_lanjut', $tindakLanjut->jenis_tindak_lanjut ?? '') == 'TPKD' ? 'selected' : '' }}>
                                    TPKD </option>

                            </select>
                        </div>

                        {{-- Validator --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label"> Validator </label>

                            <input type="text" name="validator" class="form-control" value="{{ old('validator') }}"
                                placeholder="Nama validator">

                        </div>

                        {{-- Narasi --}}

                        <div class="col-md-12 mb-3">

                            <label class="form-label"> Narasi Tindak Lanjut </label>

                            <textarea name="narasi" class="form-control" rows="5" placeholder="Masukkan uraian tindak lanjut" required>{{ old('narasi') }}</textarea>

                        </div>

                        {{-- Nilai Pengembalian --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label"> Nilai Pengembalian </label>

                            <input type="text" name="nilai_pengembalian" id="nilai_pengembalian" class="form-control"
                                value="{{ old('nilai_pengembalian') }}" placeholder="Contoh: 10.000.000">

                        </div>

                        {{-- Nilai Setor Pajak --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label"> Nilai Setor Pajak </label>

                            <input type="text" name="nilai_setor_pajak" id="nilai_setor_pajak" class="form-control"
                                value="{{ old('nilai_setor_pajak') }}" placeholder="Contoh: 5.000.000">

                        </div>

                        {{-- Tanggal Validasi --}}

                        <div class="col-md-6 mb-3">

                            <label class="form-label"> Tanggal Validasi </label>

                            <input type="date" name="tanggal_validasi" class="form-control"
                                value="{{ old('tanggal_validasi') }}">

                        </div>

                        <div class="mb-3">

                            <label class="form-label"> Upload Dokumen Tindak Lanjut </label>

                            <input type="file" name="dokumen[]" class="form-control" multiple>

                            <small class="text-muted"> Bisa upload lebih dari satu file (PDF, Word, Excel, JPG) </small>

                        </div>

                        <div class="mb-3"> <label class="form-label">Keterangan</label>

                            <textarea name="keterangan" class="form-control" rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <button type="submit" class="btn btn-success">

                        <i class="bi bi-save"></i>

                        Simpan Tindak Lanjut

                    </button>

                </div>

            </div>

        </form>

    </div>

    <script>
        function formatRupiah(input) {

            input.addEventListener('input', function() {

                let value = this.value;

                value = value.replace(/[^\d,]/g, '');

                const parts = value.split(',');

                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                this.value = parts.join(',');

            });

        }


        const nilaiFinansial = document.getElementById('nilai_pengembalian');
        const nilaiPajak = document.getElementById('nilai_setor_pajak');


        if (nilaiFinansial) {
            formatRupiah(nilaiFinansial);
        }


        if (nilaiPajak) {
            formatRupiah(nilaiPajak);
        }
        
    </script>
@endsection
