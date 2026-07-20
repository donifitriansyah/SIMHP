<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" id="create_role" class="form-select" required>
                            <option value="super_user">Super Admin</option>
                            <option value="user_entry">User Entry</option>
                            <option value="user_view">User View</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="create_irban_group">
                        <label>Irban</label>
                        <select name="irban_id" id="create_irban" class="form-select">
                            <option value="">-- Pilih Irban --</option>

                            @foreach ($irbans as $irban)
                                <option value="{{ $irban->id }}">
                                    {{ $irban->nama_irban }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const role = document.getElementById('create_role');
        const irbanGroup = document.getElementById('create_irban_group');
        const irban = document.getElementById('create_irban');

        function toggleIrban() {
            if (role.value === 'user_view') {
                irbanGroup.classList.remove('d-none');
                irban.setAttribute('required', 'required');
            } else {
                irbanGroup.classList.add('d-none');
                irban.removeAttribute('required');
                irban.value = '';
            }
        }

        toggleIrban();

        role.addEventListener('change', toggleIrban);

    });
</script>
