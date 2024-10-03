@extends('layouts.app')

@section('content')
<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Attributes</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Attribute
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">New Attribute</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="attribute_name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="attribute_name" placeholder="Enter attribute name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
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
                    <tr>
                        <td>1</td>
                        <td>Attribute name 1</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="#" class="btn btn-sm text-bg-warning">Edit</a>
                                <a href="#" class="btn btn-sm text-bg-danger">Remove</a>
                            </div>
                        </td>
                    </tr>
                   </tbody>
                </table>
            </div>
            
        </div>
    </div>
</section>
@endsection
