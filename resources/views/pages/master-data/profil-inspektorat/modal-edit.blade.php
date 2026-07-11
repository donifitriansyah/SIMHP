<div class="modal" id="editModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form action="{{ route('profil-inspektorat.update',$profil->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Profil Inspektorat
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Nama Instansi</label>

                        <input type="text"
                               name="nama"
                               value="{{ $profil->nama }}"
                               class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Alamat</label>

                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control">{{ $profil->alamat }}</textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label>Telepon</label>

                            <input type="text"
                                   name="telepon"
                                   value="{{ $profil->telepon }}"
                                   class="form-control">

                        </div>

                        <div class="col-md-6">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   value="{{ $profil->email }}"
                                   class="form-control">

                        </div>

                    </div>

                    <div class="mt-3">

                        <label>Logo Baru</label>

                        <input type="file"
                               name="logo"
                               class="form-control">

                    </div>

                    @if($profil->logo)

                        <div class="mt-3">

                            <img src="{{ asset('storage/'.$profil->logo) }}"
                                 width="120"
                                 class="img-thumbnail">

                        </div>

                    @endif

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
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
