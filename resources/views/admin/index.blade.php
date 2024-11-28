@extends('layouts.main')

@section('main-section')

<div class="row">

    <div class="col-md-3">
        <div class="card ">
        <div class="card-body">
            <h5 class="card-title">Total Trainers</h5>
            <p class="card-text">{{$trainersCount}}</p>
        </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">Total Exercises</h5>
            <p class="card-text">{{$exerciseCount}}</p>
        </div>
        </div>
    </div>
</div>


@endsection