<div class="modal fade" id="createModal">

    <div class="modal-dialog">

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5>Tambah User</h5>

                    <button class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Nama</label>

                        <input type="text" name="name" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Username</label>

                        <input type="text" name="username" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input type="email" name="email" class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Password</label>

                        <input type="password" name="password" class="form-control" required>

                    </div>

                    <div class="row">

                        <div class="col">

                            <label>Role</label>

                            <select name="role" class="form-select">

                                <option value="super_user">
                                    Super Admin
                                </option>

                                <option value="user_entry">
                                    User Entry
                                </option>

                            </select>

                        </div>

                        <div class="col">

                            <label>Status</label>

                            <select name="status" class="form-select">

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-bs-dismiss="modal">

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
