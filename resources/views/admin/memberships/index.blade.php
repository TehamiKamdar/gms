@extends('layouts.main')
@section('title')
Membership
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
            <form action="{{ route('membership-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="type" placeholder="Membership Type" id="" class="form-control mt-3">
                    <input type="text" name="duration" placeholder="Duration (in days)" id="" class="form-control mt-3">
                    <input type="text" name="price" placeholder="Price" id="" class="form-control mt-3">
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
                <th scope="col">Type</th>
                <th scope="col">Price</th>
                <th scope="col">Duration (in days)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($memberships->count()>0)
                
            @foreach ($memberships as $m)
                <tr class="">
                    <td>{{$m->type}}</td>
                    <td>{{$m->price}}</td>
                    <td>{{$m->duration}}</td>
                    <td>
                        @if ($m->status == 'active')
                            <form action="{{route('membership-inactive', $m->id)}}" method="post">
                                @csrf
                                <button class="btn btn-danger mx-1">Inactive</button>
                            </form>
                        @else
                            <form action="{{route('membership-active', $m->id)}}" method="post">
                                @csrf
                                <button class="btn btn-success mx-1">Active</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No Memberships Decided Yet</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>