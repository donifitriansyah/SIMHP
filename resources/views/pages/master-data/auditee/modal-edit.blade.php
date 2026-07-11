<div class="modal fade" id="editModal{{ $auditee->id }}" tabindex="-1">


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <form action="{{ route('auditee.update', $auditee->id) }}" method="POST">


            @csrf

            @method('PUT')


            <div class="modal-content">


                <div class="modal-header">


                    <h5>

                        Edit Auditee

                    </h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal">

                    </button>


                </div>




                <div class="modal-body">



                    <div class="mb-3">


                        <label>

                            Nama Dinas

                        </label>


                        <input type="text" name="nama_dinas" class="form-control" value="{{ $auditee->nama_dinas }}">


                    </div>



                    <div class="mb-3">


                        <label>

                            Alamat

                        </label>


                        <textarea name="alamat" class="form-control">{{ $auditee->alamat }}</textarea>


                    </div>




                    <hr>


                    <h6>

                        Pejabat Auditee

                    </h6>



                    @foreach ($auditee->pejabat as $key => $p)
                        <div class="row mb-3">


                            <input type="hidden" name="pejabat[{{ $key }}][id]" value="{{ $p->id }}">



                            <div class="col-md-8">


                                <label>

                                    {{ $p->jenis_jabatan }}

                                </label>


                                <input type="hidden" name="pejabat[{{ $key }}][jenis_jabatan]"
                                    value="{{ $p->jenis_jabatan }}">


                                <input type="text" name="pejabat[{{ $key }}][nama]"
                                    value="{{ $p->nama }}" class="form-control">

                            </div>

                            <div class="col-md-4">


                                <label>

                                    Tahun

                                </label>


                                <input type="number" name="pejabat[{{ $key }}][tahun]"
                                    value="{{ $p->tahun }}" class="form-control">


                            </div>



                        </div>
                    @endforeach




                </div>




                <div class="modal-footer">


                    <button class="btn btn-secondary" data-bs-dismiss="modal">

                        Batal

                    </button>



                    <button class="btn btn-warning">

                        Update

                    </button>


                </div>



            </div>


        </form>


    </div>


</div>
