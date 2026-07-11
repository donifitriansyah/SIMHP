<div class="modal fade" id="createModal" tabindex="-1">


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <form action="{{ route('auditee.store') }}" method="POST">


            @csrf


            <div class="modal-content">



                <div class="modal-header">


                    <h5 class="modal-title">

                        Tambah Data Auditee

                    </h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal">

                    </button>


                </div>



                <div class="modal-body">



                    <div class="mb-3">


                        <label class="form-label">
                            Nama Dinas
                        </label>


                        <input type="text" name="nama_dinas" class="form-control" required>


                    </div>



                    <div class="mb-3">


                        <label>
                            Alamat
                        </label>


                        <textarea name="alamat" class="form-control" rows="3"></textarea>


                    </div>



                    <hr>


                    <h6 class="mb-3">

                        Data Pejabat Auditee

                    </h6>



                    @php

                        $jabatan = ['PIMPINAN', 'PPK', 'PPTK'];

                    @endphp



                    @foreach ($jabatan as $key => $jab)
                        <div class="row mb-3">


                            <div class="col-md-8">


                                <label>

                                    Nama {{ $jab }}

                                </label>


                                <input type="hidden" name="pejabat[{{ $key }}][jenis_jabatan]"
                                    value="{{ $jab }}">


                                <input type="text" name="pejabat[{{ $key }}][nama]" class="form-control">


                            </div>




                            <div class="col-md-4">


                                <label>

                                    Tahun

                                </label>


                                <input type="number" name="pejabat[{{ $key }}][tahun]" class="form-control">


                            </div>



                        </div>
                    @endforeach



                </div>




                <div class="modal-footer">


                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Batal

                    </button>



                    <button class="btn btn-primary">

                        Simpan

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>
