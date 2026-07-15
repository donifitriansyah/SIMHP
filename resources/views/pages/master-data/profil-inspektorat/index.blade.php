@extends('layouts.backend')

@section('title', 'Profil Inspektorat')

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-building"></i>
                    Profil Inspektorat
                </h5>

                @if (auth()->check() && auth()->user()->role == 'super_user')

                    @if ($profil)
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </button>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="bi bi-plus-circle"></i>
                            Tambah
                        </button>
                    @endif

                @endif

            </div>

            <div class="card-body">

                @if ($profil)

                    <div class="row">

                        <div class="col-md-3 text-center">

                            @if ($profil->logo)
                                <img src="{{ asset('storage/' . $profil->logo) }}" class="img-fluid rounded shadow"
                                    style="max-height:180px;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded shadow"
                                    style="max-height:180px;">
                            @endif

                        </div>

                        <div class="col-md-9">

                            <table class="table table-borderless">

                                <tr>
                                    <th width="180">Nama Instansi</th>
                                    <td>{{ $profil->nama }}</td>
                                </tr>

                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $profil->alamat }}</td>
                                </tr>

                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $profil->telepon }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $profil->email }}</td>
                                </tr>

                            </table>

                        </div>

                    </div>
                @else
                    <div class="text-center py-5">

                        <h5>Data Profil Belum Tersedia</h5>

                        <p class="text-muted">
                            Silakan tambahkan profil Inspektorat.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

    @include('pages.master-data.profil-inspektorat.modal-create')

    @if ($profil)
        @include('pages.master-data.profil-inspektorat.modal-edit')
    @endif

@endsection
