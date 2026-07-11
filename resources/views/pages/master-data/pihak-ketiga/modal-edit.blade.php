@foreach ($pihakKetigas as $p)

<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">


    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Data Pihak Ketiga
                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>




            <form action="{{ route('pihak-ketiga.update', $p->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                <div class="modal-body">


                    <div class="mb-3">

                        <label class="form-label">
                            Nama Perusahaan
                        </label>


                        <input type="text"
                               name="nama_perusahaan"
                               class="form-control"
                               value="{{ $p->nama_perusahaan }}"
                               required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Nama Pimpinan
                        </label>


                        <input type="text"
                               name="nama_pimpinan"
                               class="form-control"
                               value="{{ $p->nama_pimpinan }}"
                               required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>


                        <textarea name="alamat"
                                  class="form-control"
                                  rows="3">{{ $p->alamat }}</textarea>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Paket Pekerjaan
                        </label>


                        <textarea name="paket_pekerjaan"
                                  class="form-control"
                                  rows="3">{{ $p->paket_pekerjaan }}</textarea>

                    </div>



                </div>




                <div class="modal-footer">


                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Tutup

                    </button>



                    <button type="submit"
                            class="btn btn-warning">

                        Update

                    </button>


                </div>



            </form>


        </div>

    </div>


</div>


@endforeach
