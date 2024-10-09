@extends('layouts.app')

@section('title', ' Calculation Training Data')

@section('content')
<div class="page-title mb-3">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Calculation Training</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Recalculate
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('calculation.training.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recalculate</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to recalculate the <b>probability</b>?
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
        <h5 class="mb-3">Table: Prior Probability Class</h5>
        <table class="table table-striped">
            <thead>
                <th>No</th>
                <th>Class Name</th>
                <th>Total Training Data</th>
                <th>P(<i>C<small class="fst-italic">i</small></i>) / Total Data</th>
                <th>Prior probability</th>
            </thead>
           
            <tbody>
                @if (count($prior_classes) <= 0)
                    <tr class="text-center">
                        <td colspan="5">No data available.</td>
                    </tr>
                @endif
               
                @foreach ($prior_classes as $pclass)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pclass->class->name }}</td>
                        <td>{{ $pclass->total_data }}</td>
                        <td>{{ $pclass->total_data .' / '.$prior_classes->sum('total_data') }}</td>
                        <td>{{ $pclass->prior_probability }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <h5>Probability Attributes</h5>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
               <tr>
                    <th rowspan="2">Frequency Table</th>
                    <th colspan="2" class="text-center">Class</th>
               </tr>
               <tr class="text-center">
                    @foreach ($classes as $class)
                        <th>{{ $class->name }}</th>
                    @endforeach
               </tr>
            </thead>
            <tbody>
                <tr>
                    <td>sadas</td>
                    <td>10</td>
                    <td>12</td>
                </tr>
            </tbody>
        </table>
        <hr>
        
        @foreach ($classes as $class)
            <table class="table table-striped">
                <thead>
                    <th>{{ $class->name }}</th>
                </thead>
                <tbody>
                    {{dd($prior_attributes->where('class_label_id', $class->id)->orderBy('attribute_id')->get())}}
                    @foreach ($prior_attributes->where('class_label_id', $class->id)->orderBy('attribute_id')->get() as $prior_attribute)
                        <tr>
                            <td>{{ $prior_attribute->attribute_value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        
    </div>
</div>
@endsection

