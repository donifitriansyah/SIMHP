@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Tambah Data LHP
                </h4>

                <p class="text-muted mb-0">
                    Input laporan hasil pemeriksaan baru
                </p>
            </div>


            <a href="{{ url()->previous() }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>




        <form enctype="multipart/form-data" action="{{ route('lhp.store') }}" method="POST">

            @csrf



            {{-- Informasi LHP --}}
            <div class="card border-0 shadow-sm mb-4">


                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        Informasi LHP
                    </h5>

                </div>



                <div class="card-body">


                    <div class="row">


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nomor LHP
                            </label>

                            <input type="text" name="nomor_lhp"
                                class="form-control @error('nomor_lhp') is-invalid @enderror" value="{{ old('nomor_lhp') }}"
                                placeholder="Contoh: 700/LHP/2026" required>


                            @error('nomor_lhp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal LHP
                            </label>

                            <input type="date" name="tanggal_lhp" class="form-control" value="{{ old('tanggal_lhp') }}"
                                required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nomor Surat Tugas
                            </label>

                            <input type="text" name="nomor_spt" class="form-control" value="{{ old('nomor_spt') }}"
                                required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal SPT
                            </label>

                            <input type="date" name="tanggal_spt" class="form-control" value="{{ old('tanggal_spt') }}"
                                required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tahun PKPT
                            </label>

                            <input type="number" name="tahun_pkpt" class="form-control"
                                value="{{ old('tahun_pkpt', date('Y')) }}" required>

                        </div>
                        @if ($jenis == 'internal')
                            <input type="hidden" name="instansi_pemeriksa" value="Itkab">
                        @endif
                        @if ($jenis == 'eksternal')
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Instansi Pemeriksa
                                </label>

                                <select name="instansi_pemeriksa" class="form-select" required>

                                    <option value="">
                                        -- Pilih Instansi Pemeriksa --
                                    </option>

                                    @foreach (\App\Models\Lhp::getInstansiPemeriksa() as $value => $label)
                                        @if ($value != 'Itkab')
                                            <option value="{{ $value }}"
                                                {{ old('instansi_pemeriksa') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>

                            </div>
                        @endif


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jumlah Dana Diawasi
                            </label>

                            <input type="text" name="jumlah_dana_diawasi" id="jumlah_dana_diawasi" class="form-control"
                                value="{{ old('jumlah_dana_diawasi') }}" placeholder="Masukkan nominal">

                        </div>



                    </div>


                </div>


            </div>





            {{-- Entitas Pemeriksaan --}}
            <div class="card border-0 shadow-sm mb-4">


                <div class="card-header bg-info text-white">

                    <h5 class="mb-0">
                        Entitas Pemeriksaan
                    </h5>

                </div>



                <div class="card-body">


                    <div class="row">


                        <div class="col-md-6 mb-3" id="irban-group">

                            <label class="form-label">
                                Irban
                            </label>

                            <select name="irban_id" id="irban_id" class="form-select">

                                <option value="">Pilih Irban</option>

                                @foreach ($irbans as $irban)
                                    <option value="{{ $irban->id }}" @selected(old('irban_id') == $irban->id)>
                                        {{ $irban->nama_irban }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        @if ($jenis == 'eksternal')
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nama Pejabat
                                </label>

                                <input type="text" name="nama_pejabat_eksternal" class="form-control"
                                    value="{{ old('nama_pejabat_eksternal') }}" placeholder="Masukkan nama pejabat">

                            </div>
                        @endif
                        @if ($jenis == 'internal')
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Auditee / Entitas Diperiksa
                                </label>


                                <select name="auditee_id" id="auditee" class="form-select">

                                    <option value="">
                                        -- Pilih Auditee --
                                    </option>

                                    @foreach ($auditees as $auditee)
                                        <option value="{{ $auditee->id }}">

                                            {{ $auditee->nama_dinas }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">

                                    Pejabat yang Diperiksa

                                </label>

                                <select name="pejabat_auditee_id" id="pejabat" class="form-select">

                                    <option value="">
                                        Pilih Auditee terlebih dahulu
                                    </option>

                                </select>

                            </div>
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Pihak Ketiga
                                </label>


                                <select name="pihak_ketiga_id" class="form-select">


                                    <option value="">
                                        Tidak Ada
                                    </option>


                                    @foreach ($pihakKetigas as $pihak)
                                        <option value="{{ $pihak->id }}">

                                            {{ $pihak->nama_perusahaan }}

                                        </option>
                                    @endforeach


                                </select>

                            </div>
                        @endif



                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Objek Pemeriksaan
                            </label>


                            <input type="text" name="objek_pemeriksaan" class="form-control"
                                value="{{ old('objek_pemeriksaan', $lhp->objek_pemeriksaan ?? '') }}"
                                placeholder="Masukkan objek pemeriksaan">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Dokumen LHP
                            </label>

                            <input type="file" name="dokumen[]" multiple class="form-control"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">

                            <small class="text-muted">
                                PDF, Word, Excel, JPG, PNG
                            </small>

                        </div>

                    </div>


                </div>


            </div>





            {{-- Jenis Pemeriksaan --}}
            <div class="card border-0 shadow-sm mb-4">


                <div class="card-header">

                    <h5 class="mb-0">
                        Jenis Pemeriksaan
                    </h5>

                </div>



                <div class="card-body">


                    <select name="jenis_pemeriksaan" class="form-select" required>


                        <option value="">
                            Pilih Jenis Pemeriksaan
                        </option>


                        <option value="PKPT">
                            PKPT
                        </option>


                        <option value="PDTT">
                            PDTT
                        </option>


                        <option value="Kasus">
                            Kasus
                        </option>


                    </select>


                </div>


            </div>





            <div class="text-end">


                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Simpan LHP

                </button>


            </div>


        </form>


    </div>

    <script>
        const instansi = document.querySelector('select[name="instansi_pemeriksa"]');
        const irbanGroup = document.getElementById('irban-group');
        const irban = document.getElementById('irban_id');

        function toggleIrban() {

            if (!instansi) return;

            if (instansi.value === 'BPK RI' || instansi.value === 'BPKP') {

                irbanGroup.classList.add('d-none');
                irban.removeAttribute('required');
                irban.value = '';

            } else {

                irbanGroup.classList.remove('d-none');
                irban.setAttribute('required', 'required');

            }
        }

        if (instansi) {
            toggleIrban();
            instansi.addEventListener('change', toggleIrban);
        }
        const input = document.getElementById('jumlah_dana_diawasi');

        input.addEventListener('input', function() {

            let value = this.value;

            value = value.replace(/[^\d,]/g, '');

            const parts = value.split(',');

            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            this.value = parts.join(',');

        });

        document.getElementById('auditee').addEventListener('change', function() {

            let auditee = this.value;

            let pejabat = document.getElementById('pejabat');

            pejabat.innerHTML =
                '<option>Memuat data...</option>';

            if (auditee == "") {
                pejabat.innerHTML =
                    '<option>Pilih Auditee terlebih dahulu</option>';

                return;
            }

            fetch('/auditee/' + auditee + '/pejabat')

                .then(response => response.json())

                .then(data => {

                    pejabat.innerHTML = '';

                    pejabat.innerHTML +=
                        '<option value="">-- Pilih Pejabat --</option>';

                    data.forEach(function(item) {

                        pejabat.innerHTML += `

                <option value="${item.id}">

                    ${item.nama}
                    (${item.jenis_jabatan})

                </option>

            `;

                    });

                });

        });
    </script>
@endsection
