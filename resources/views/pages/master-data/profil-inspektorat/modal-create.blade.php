<div class="modal" id="createModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form action="{{ route('profil-inspektorat.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Profil Inspektorat
                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Nama Instansi</label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label>Alamat</label>

                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label>Telepon</label>

                            <input type="text"
                                   name="telepon"
                                   class="form-control">

                        </div>

                        <div class="col-md-6">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control">

                        </div>

                    </div>

                    <div class="mt-3">

                        <label>Logo</label>

                        <input type="file"
                               name="logo"
                               class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
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
