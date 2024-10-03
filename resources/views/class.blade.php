@extends('layouts.app')

@section('title', ' Clases')

@section('content')
<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Clases</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Class
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('class.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Class</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="attribute_name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="attribute_name" placeholder="Enter class name" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-content">
            <div class="table-responsive">
                <table class="table mb-0 table-lg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clases as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $class->name }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Edit button --}}
                                        <button type="button" class="btn btn-sm text-bg-warning edit" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $class->id }}" data-name="{{ $class->name }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        {{-- Delete button --}}
                                        <button type="button" class="btn btn-sm btn-danger delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $class->id }}" data-name="{{ $class->name }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="POST" id="formUpdate">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Class</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required id="editName" placeholder="Enter class name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">
                        Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Class</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="formDelete" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <label for="confirm_delete" class="form-label">
                        Are you sure you want to delete, <span id="modalName" class="text-danger fw-bold"></span>?
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete it.</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $('.edit').click(function(e) {
            let name = $(this).data('name');
            let id = $(this).data('id');
            // Insert Value Edit
            $('#editName').val(name);
            // Route update
            let url = "{{ route('class.update', ':id') }}";
            route = url.replace(':id', id);
            // Action route for update
            $('#formUpdate').attr('action', route);
        });
        // Delete Modal
        $('.delete').click(function(e) {
            let name = $(this).data('name');
            let id = $(this).data('id');
            $('#modalName').html(name);
            // Route delete
            let url = "{{ route('class.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush
