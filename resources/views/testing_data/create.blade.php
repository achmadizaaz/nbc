@extends('layouts.app')

@section('title', ' Create Testing Data')

@section('content')
<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Create Testing Data</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{  route('testing') }}" class="btn btn-secondary">
                    Back
                </a>
            </nav>
        </div>
    </div>
    
</div>

{{-- Alert errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Errors:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
{{-- End Alert errors --}}

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<section class="section">
    <div class="card">
        <div class="card-body">
           <form action="{{ route('testing.store') }}" method="POST">
            @csrf
                <div class="row">
                    <div class="mb-3 col-3 col-md-4">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    @foreach ($attributes as $item)
                        <div class="mb-3 col-3 col-md-4">
                            <label for="{{ $item->name }}" class="form-label fw-bold">{{ $item->name }}</label>
                            <input type="text" class="form-control" name="attribute[{{ $item->id }}]" id="{{ $item->name }}" required>
                        </div>
                    @endforeach
                    <div class="mb-3 col-3 col-md-4">
                        <label for="class" class="form-label fw-bold">Class</label>
                        <select name="class" class="form-select" id="class" required>
                            <option value="">Choose a clases</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                
                <div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
           </form>
        </div>
    </div>
</section>
@endsection

