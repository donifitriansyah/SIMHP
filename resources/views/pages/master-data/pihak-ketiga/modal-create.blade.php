<div class="modal fade" id="modalCreate" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Tambah Data Pihak Ketiga
                </h5>


                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>




            <form action="{{ route('pihak-ketiga.store') }}" method="POST">

                @csrf



                <div class="modal-body">


                    <div class="mb-3">

                        <label class="form-label">
                            Nama Perusahaan
                        </label>


                        <input type="text" name="nama_perusahaan" class="form-control"
                            placeholder="Masukkan nama perusahaan" required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Nama Pimpinan
                        </label>


                        <input type="text" name="nama_pimpinan" class="form-control"
                            placeholder="Masukkan nama pimpinan" required>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>


                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>

                    </div>




                    <div class="mb-3">

                        <label class="form-label">
                            Paket Pekerjaan
                        </label>


                        <textarea name="paket_pekerjaan" class="form-control" rows="3" placeholder="Masukkan paket pekerjaan"></textarea>

                    </div>



                </div>





                <div class="modal-footer">


                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Tutup

                    </button>




                    <button type="submit" class="btn btn-primary">

                        Simpan

                    </button>


                </div>



            </form>


        </div>

    </div>

</div>
