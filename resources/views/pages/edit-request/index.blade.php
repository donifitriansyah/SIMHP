@extends('layouts.backend')

@section('title', 'Permintaan Edit')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">

                Permintaan Akses Edit

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable">

                    <thead class="table-primary">

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>User</th>

                            <th>No LHP</th>

                            <th>Alasan</th>

                            <th>Status</th>

                            <th width="170">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($requests as $request)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>

                            <td>{{ $request->user->name }}</td>

                            <td>{{ $request->lhp->nomor_lhp }}</td>


                            <td>{{ $request->alasan }}</td>

                            <td>

                                @if($request->status=='pending')

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                @elseif($request->status=='approved')

                                    <span class="badge bg-success">

                                        Approved

                                    </span>

                                @elseif($request->status=='rejected')

                                    <span class="badge bg-danger">

                                        Rejected

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Completed

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($request->status=='pending')

                                    <form
                                        action="{{ route('edit-requests.approve',$request) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('PUT')

                                        <button
                                            class="btn btn-success btn-sm">

                                            Approve

                                        </button>

                                    </form>

                                    <form
                                        action="{{ route('edit-requests.reject',$request) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('PUT')

                                        <button
                                            class="btn btn-danger btn-sm">

                                            Reject

                                        </button>

                                    </form>

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                        @empty

                        

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
