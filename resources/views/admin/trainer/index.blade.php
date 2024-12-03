@extends('layouts.main')
@section('title')
Trainer
@endsection
@section('main-section')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('trainers-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Trainer Name" id="" class="form-control mt-3">
                    <input type="text" name="email" placeholder="Trainier Email" id="" class="form-control mt-3">
                    <input type="text" name="phone" placeholder="Trainer Phone" id="" class="form-control mt-3">
                    <input type="text" name="salary" placeholder="Trainer Salary" id="" class="form-control mt-3">
                    <select name="specialization" class="form-control mt-3" id="">
                        <option value="" disabled selected>Select Speciality</option>
                        @foreach ($specializations as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive mt-3">
    <table class="table table-primary">
        <thead>
            <tr>
                <th scope="col">Trainer Name</th>
                <th scope="col">Specialization</th>
                <th scope="col">Phone</th>
                <th scope="col">Salary</th>
            </tr>
        </thead>
        <tbody>
            @if ($trainers->count() > 0)
                @foreach ($trainers as $t)
                    <tr class="">
                        <td>{{$t->trainer_name}}</td>
                        <td>{{$t->specialization}}</td>
                        <td>{{$t->phone}}</td>
                        <td>{{$t->salary}}</td>
                        <td>
                            <button type="button" class="btn btn-primary open-modal-update" data-id="{{$t->trainer_id}}" data-bs-target="#modalUpdate" data-bs-toggle="modal">Update</button>
                            <button type="button" class="mx-1 btn btn-danger open-modal-delete" data-id="{{$t->trainer_id}}" data-bs-target="#modalDelete" data-bs-toggle="modal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No Trainers Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal1">Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('trainer-update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" placeholder="Trainer Name" id="id" class="form-control mt-3">
                    <input type="text" name="name_" placeholder="Trainer Name" id="name_" class="form-control mt-3">
                    <input type="text" name="email_" placeholder="Trainier Email" id="email_" class="form-control mt-3">
                    <input type="text" name="phone_" placeholder="Trainer Phone" id="phone_" class="form-control mt-3">
                    <input type="text" name="salary_" placeholder="Trainer Salary" id="salary_" class="form-control mt-3">
                    <select name="specialization" class="form-control mt-3" id="" disabled>
                        <option value="" disabled selected>Select Speciality</option>
                        @foreach ($specializations as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
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
            <form action="{{ route('trainer-delete') }}" method="post">
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
                url: 'trainer/get-trainer/' + id,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#modalUpdate').modal('show');
                    $('#id').val(response.id);
                    $('#name_').val(response.name || 'Hello');
                    $('#email_').val(response.email || '');
                    $('#phone_').val(response.phone || '');
                    $('#salary_').val(response.salary || '');
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
                url: 'trainer/get-trainer/' + id,
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