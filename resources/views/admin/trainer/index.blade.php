@extends('layouts.main')
@section('title')
    Trainers
@endsection
@section('main-section')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('trainers-store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="name" placeholder="Trainer Name" id=""
                            class="form-control mt-3">
                        <input type="text" name="email" placeholder="Trainier Email" id=""
                            class="form-control mt-3">
                        <input type="text" name="phone" placeholder="Trainer Phone" id=""
                            class="form-control mt-3">
                        <input type="text" name="salary" placeholder="Trainer Salary" id=""
                            class="form-control mt-3">
                        <select name="specialization" class="form-control mt-3" id="">
                            <option value="" disabled selected>Select an Option..</option>
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
    <div class="table-responsive">
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
                @foreach ($trainers as $t)
                    <tr class="">
                        <td>{{$t->trainer_name}}</td>
                        <td>{{$t->specialization}}</td>
                        <td>{{$t->phone}}</td>
                        <td>{{$t->salary}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
