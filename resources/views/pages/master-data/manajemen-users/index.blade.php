@extends('layouts.backend')

@section('title', 'Manajemen User')

@section('content')

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-1">
                    <i class="bi bi-people-fill me-2"></i>
                    Manajemen User
                </h5>

                <small class="text-muted">
                    Kelola akun pengguna SIMHP
                </small>

            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah User

            </button>

        </div>

        <div class="card-body">



            <div class="table-responsive">

                <table id="dataTable" class="table table-hover align-middle">


                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>

                            <th>Nama</th>

                            <th>Username</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Status</th>

                            <th width="150">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->username }}</td>

                                <td>{{ $user->email }}</td>

                                <td>

                                    @if ($user->role == 'super_user')
                                        <span class="badge bg-danger">
                                            Super Admin
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            User Entry
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    @if ($user->status)
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $user->id }}">

                                        <i class="bi bi-pencil-square"></i>

                                    </button>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm btn-delete">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @include('pages.master-data.manajemen-users.modal-edit')

                        @empty

                            
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

    </div>



    @include('pages.master-data.manajemen-users.modal-create')

@endsection
