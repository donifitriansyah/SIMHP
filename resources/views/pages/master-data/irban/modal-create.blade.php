<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">


        <form action="{{ route('irban.store') }}" method="POST">

            @csrf


            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title" id="createModalLabel">

                        <i class="bi bi-person-badge me-2"></i>
                        Tambah Data Irban

                    </h5>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>



                <div class="modal-body">


                    {{-- Kode Irban --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Kode Irban
                        </label>


                        <input type="text"
                               name="kode"
                               class="form-control @error('kode') is-invalid @enderror"
                               placeholder="Contoh : IRBAN-1"
                               value="{{ old('kode') }}"
                               required>


                        @error('kode')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


                    </div>



                    {{-- Nama Irban --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Irban
                        </label>


                        <input type="text"
                               name="nama_irban"
                               class="form-control @error('nama_irban') is-invalid @enderror"
                               placeholder="Contoh : Irban I"
                               value="{{ old('nama_irban') }}"
                               required>


                        @error('nama_irban')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


                    </div>


                    {{-- Status --}}

                    <div class="mb-3">
                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">
                            <option value="1">
                                Aktif
                            </option>

                            <option value="0">
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
