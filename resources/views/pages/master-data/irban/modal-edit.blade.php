<div class="modal fade"
     id="editModal{{ $irban->id }}"
     tabindex="-1"
     aria-labelledby="editModalLabel"
     aria-hidden="true">


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <form action="{{ route('irban.update', $irban->id) }}"
              method="POST">


            @csrf
            @method('PUT')


            <div class="modal-content">


                <div class="modal-header">


                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Data Irban

                    </h5>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
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
                               class="form-control"
                               value="{{ $irban->kode }}"
                               required>


                    </div>




                    {{-- Nama Irban --}}

                    <div class="mb-3">


                        <label class="form-label">

                            Nama Irban

                        </label>


                        <input type="text"
                               name="nama_irban"
                               class="form-control"
                               value="{{ $irban->nama_irban }}"
                               required>


                    </div>

                    {{-- Status --}}

                    <div class="mb-3">


                        <label class="form-label">

                            Status

                        </label>


                        <select name="status"
                                class="form-select">


                            <option value="1"
                                {{ $irban->status == 1 ? 'selected' : '' }}>

                                Aktif

                            </option>


                            <option value="0"
                                {{ $irban->status == 0 ? 'selected' : '' }}>

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
                            class="btn btn-warning">


                        <i class="bi bi-save me-1"></i>

                        Update


                    </button>


                </div>


            </div>


        </form>


    </div>


</div>
