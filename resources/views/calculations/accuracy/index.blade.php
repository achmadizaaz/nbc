@extends('layouts.app')

@section('title', 'Accuracy Calculation Testing Data')

@section('content')
<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Accuracy Calculation</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Calculate Accuracy
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    Show Calculate Accuracy
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('calculation.training.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Calculate Accuracy</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to recalculate the <b>Accuracy</b>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Recalculate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Total Testing : {{ $countTesting }} / Data</h5>
        <small class="fst-italic">Detailed testing data can be seen in the <a href="{{ route('testing') }}"><b>Testing Data</b></a> menu</small>
    </div>
</div>
@endsection

