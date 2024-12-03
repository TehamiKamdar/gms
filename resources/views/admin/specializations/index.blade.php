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
@if (session('update'))
    <div class="alert alert-success">
        {{ session('update') }}
    </div>
@endif
@if (session('delete'))
    <div class="alert alert-danger">
        {{ session('delete') }}
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
                <h5 class="modal-title" id="exampleModalLabel">Add New @yield('title')</h5>
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
            @if ($specializations->count() > 0)
            @foreach ($specializations as $m)
                <tr class="">
                    <td>{{$m->name}}</td>
                    <td class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary open-modal-update" data-id="{{$m->id}}"
                            data-bs-target="#modalUpdate" data-bs-toggle="modal">Update</button>
                        <button type="button" class="mx-1 btn btn-danger open-modal-delete" data-id="{{$m->id}}"
                            data-bs-target="#modalDelete" data-bs-toggle="modal">Delete</button>

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
            @else
                <tr>
                    <td colspan="2" class="text-center">No Exercises Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdate">Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('specialization-update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="text" id="name_" name="name" placeholder="Name"
                        class="form-control mt-3">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDelete">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('specialization-delete') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_" id="id_">
                    <h6>Are you sure you want to Delete?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.open-modal-update', function () {
            var id = $(this).attr('data-id'); 
            console.log(id);
            $.ajax({
                url: 'specializations/get-specialization/' + id,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#modalUpdate').modal('show');
                    $('#id').val(response.id);
                    $('#name_').val(response.name || 'Error Fetching Record');
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('Error fetching membership details.');
                }
            });
        });
        $(document).on('click', '.open-modal-delete', function () {
            var id = $(this).attr('data-id'); 
            console.log(id);
            $.ajax({
                url: 'specializations/get-specialization/' + id,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#modalDelete').modal('show');
                    $('#id_').val(response.id);
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('Error fetching membership details.');
                }
            });
        });
    });
</script>
@endsection