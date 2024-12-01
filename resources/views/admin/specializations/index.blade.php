@extends('layouts.main')
@section('title')

Specialization
   
@endsection

@section('main-section')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('active'))
    <div class="alert alert-success">
        {{ session('active') }}
    </div>
@endif
@if (session('inactive'))
    <div class="alert alert-danger">
        {{ session('inactive') }}
    </div>
@endif
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add New @yield('title')
</button>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('specialization-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Specialization" id="" class="form-control mt-3">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive mt-3 ">
    <table class="table table-primary text-center">
        <thead>
            <tr>
                <th scope="col">Specialization</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($specializations as $m)
                <tr class="">
                    <td>{{$m->name}}</td>
                    <td>
                        @if ($m->status == 'active')
                            <form action="{{route('specialization-inactive', $m->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger mx-1">Inactive</button>
                            </form>
                        @else
                            <form action="{{route('specialization-active', $m->id)}}" method="post">
                                @csrf
                                <button class="btn btn-success mx-1">Active</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection