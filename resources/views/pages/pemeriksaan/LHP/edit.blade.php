@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Edit Data LHP
                </h4>

                <p class="text-muted mb-0">
                    Perbarui data laporan hasil pemeriksaan
                </p>
            </div>


            <a href="{{ route('lhp.show', $lhp->id) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>




        <form enctype="multipart/form-data" action="{{ route('lhp.update', $lhp->id) }}" method="POST">

            @csrf
            @method('PUT')



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


                            <input type="text" name="nomor_lhp" class="form-control"
                                value="{{ old('nomor_lhp', $lhp->nomor_lhp) }}" required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal LHP
                            </label>


                            <input type="date" name="tanggal_lhp" class="form-control"
                                value="{{ old('tanggal_lhp', $lhp->tanggal_lhp) }}" required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nomor Surat Tugas (SPT)
                            </label>


                            <input type="text" name="nomor_spt" class="form-control"
                                value="{{ old('nomor_spt', $lhp->nomor_spt) }}" required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal SPT
                            </label>


                            <input type="date" name="tanggal_spt" class="form-control"
                                value="{{ old('tanggal_spt', $lhp->tanggal_spt) }}" required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tahun PKPT
                            </label>


                            <input type="number" name="tahun_pkpt" class="form-control"
                                value="{{ old('tahun_pkpt', $lhp->tahun_pkpt) }}" required>

                        </div>




                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jumlah Dana Diawasi
                            </label>


                            <input type="text" name="jumlah_dana_diawasi" id="jumlah_dana_diawasi" class="form-control"
                                value="{{ number_format($lhp->jumlah_dana_diawasi, 0, ',', '.') }}">


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



                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Irban
                            </label>


                            <select name="irban_id" class="form-select" required>


                                <option value="">
                                    Pilih Irban
                                </option>


                                @foreach ($irbans as $irban)
                                    <option value="{{ $irban->id }}"
                                        {{ $lhp->irban_id == $irban->id ? 'selected' : '' }}>

                                        {{ $irban->nama_irban }}

                                    </option>
                                @endforeach


                            </select>


                        </div>





                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Auditee
                            </label>


                            <select name="auditee_id" id="auditee" class="form-select" required>

                                <option value="">Pilih Auditee</option>

                                @foreach ($auditees as $auditee)
                                    <option value="{{ $auditee->id }}"
                                        {{ old('auditee_id', $lhp->auditee_id) == $auditee->id ? 'selected' : '' }}>

                                        {{ $auditee->nama_dinas }}

                                    </option>
                                @endforeach

                            </select>


                        </div>
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Pejabat
                            </label>


                            <select name="pejabat_auditee_id" id="pejabat" class="form-select" required>

                                <option value="">
                                    Pilih Pejabat
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
                                    <option value="{{ $pihak->id }}"
                                        {{ $lhp->pihak_ketiga_id == $pihak->id ? 'selected' : '' }}>


                                        {{ $pihak->nama_perusahaan }}


                                    </option>
                                @endforeach


                            </select>


                        </div>





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


                        <option value="pkpt" {{ $lhp->jenis_pemeriksaan == 'pkpt' ? 'selected' : '' }}>
                            PKPT
                        </option>


                        <option value="pdtt" {{ $lhp->jenis_pemeriksaan == 'pdtt' ? 'selected' : '' }}>
                            PDTT
                        </option>


                        <option value="kasus" {{ $lhp->jenis_pemeriksaan == 'kasus' ? 'selected' : '' }}>
                            Kasus
                        </option>


                    </select>


                </div>


            </div>






            <div class="text-end">


                <button type="submit" class="btn btn-warning">


                    <i class="bi bi-save"></i>

                    Update LHP


                </button>


            </div>




        </form>


    </div>



    <script>
        document
            .getElementById('jumlah_dana_diawasi')
            .addEventListener('keyup', function() {

                let value = this.value.replace(/\./g, '');


                if (value) {

                    this.value = new Intl.NumberFormat('id-ID')
                        .format(value);

                }

            });
    </script>
    <script>
        const auditee = document.getElementById('auditee');
        const pejabat = document.getElementById('pejabat');

        const selectedPejabat =
            "{{ old('pejabat_auditee_id', $lhp->pejabat_auditee_id) }}";

        function loadPejabat(auditeeId) {
            pejabat.innerHTML =
                '<option value="">Loading...</option>';

            fetch('/auditee/' + auditeeId + '/pejabat')

                .then(res => res.json())

                .then(data => {

                    pejabat.innerHTML =
                        '<option value="">Pilih Pejabat</option>';

                    data.forEach(item => {

                        pejabat.innerHTML += `
                    <option value="${item.id}"
                        ${item.id == selectedPejabat ? 'selected' : ''}>
                        ${item.nama} (${item.jenis_jabatan})
                    </option>
                `;

                    });

                });

        }

        auditee.addEventListener('change', function() {

            if (this.value) {

                loadPejabat(this.value);

            } else {

                pejabat.innerHTML =
                    '<option value="">Pilih Pejabat</option>';

            }

        });


        // Saat halaman Edit pertama kali dibuka
        if (auditee.value) {

            loadPejabat(auditee.value);

        }
    </script>
@endsection
