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
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}"
                            required>
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

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select edit-role" data-user="{{ $user->id }}" required>

                            <option value="super_user" @selected($user->role == 'super_user')>
                                Super Admin
                            </option>

                            <option value="user_entry" @selected($user->role == 'user_entry')>
                                User Entry
                            </option>

                            <option value="user_view" @selected($user->role == 'user_view')>
                                User View
                            </option>

                        </select>
                    </div>

                    <div class="mb-3 edit-irban-group" id="edit_irban_group_{{ $user->id }}">

                        <label>Irban</label>

                        <select name="irban_id" class="form-select edit-irban">

                            <option value="">-- Pilih Irban --</option>

                            @foreach ($irbans as $irban)
                                <option value="{{ $irban->id }}" @selected($user->irban_id == $irban->id)>
                                    {{ $irban->nama_irban }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">
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

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-warning">
                        Update
                    </button>

                </div>

            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.edit-role').forEach(function(roleSelect) {

            function toggleIrban() {

                const userId = roleSelect.dataset.user;

                const irbanGroup = document.getElementById(
                    'edit_irban_group_' + userId
                );

                const irbanSelect = irbanGroup.querySelector('.edit-irban');


                if (roleSelect.value === 'user_view') {

                    irbanGroup.classList.remove('d-none');

                    irbanSelect.setAttribute(
                        'required',
                        'required'
                    );

                } else {

                    irbanGroup.classList.add('d-none');

                    irbanSelect.removeAttribute(
                        'required'
                    );

                    irbanSelect.value = '';

                }

            }


            toggleIrban();


            roleSelect.addEventListener(
                'change',
                toggleIrban
            );

        });

    });
</script>
