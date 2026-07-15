<div class="modal fade" id="editModal{{ $user->id }}">

    <div class="modal-dialog">

        <form action="{{ route('users.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">

                    <h5>Edit User</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Nama</label>

                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">

                    </div>

                    <div class="mb-3">

                        <label>Username</label>

                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">

                    </div>

                    <div class="mb-3">

                        <label>Password Baru</label>

                        <input type="password" name="password" class="form-control">

                        <small class="text-muted">

                            Kosongkan jika tidak ingin mengganti password.

                        </small>

                    </div>

                    <div class="row">

                        <div class="col">

                            <label>Role</label>

                            <select name="role" class="form-select">

                                <option value="super_user" @selected($user->role == 'super_user')>

                                    Super Admin

                                </option>

                                <option value="user_entry" @selected($user->role == 'user_entry')>

                                    User

                                </option>

                            </select>

                        </div>

                        <div class="col">

                            <label>Status</label>

                            <select name="status" class="form-select">

                                <option value="1" @selected($user->status)>

                                    Aktif

                                </option>

                                <option value="0" @selected(!$user->status)>

                                    Nonaktif

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
