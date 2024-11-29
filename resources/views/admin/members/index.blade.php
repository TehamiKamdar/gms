@extends('layouts.main')
@section('title')
    Members
@endsection
@section('main-section')
    @if (session('success'))
        <div class="alert alert-primary">
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
                <form action="{{ route('members-store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="first_name" id="first_name" placeholder="First Name"
                            class="form-control mt-3" required>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                            class="form-control mt-3" required>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control mt-3"
                            required>
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control mt-3"
                            required>
                        <input type="text" name="address" id="address" placeholder="Address" class="form-control mt-3"
                            required>

                        <!-- Membership Selection -->
                        <select name="membership_id" id="membership" class="form-control mt-3" required>
                            <option value="">Select Membership..</option>
                            @foreach ($memberships as $m)
                                <option value="{{ $m->id }}" data-duration="{{ $m->duration }}">{{ $m->type }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Start Date -->
                        <input type="date" name="joining_date" class="form-control mt-3" required>

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
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Membership</th>
                    <th scope="col">Joining Date</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($members->count() > 0)
                    @foreach ($members as $mem)
                        <tr class="">
                            <td>{{ $mem->first_name }}</td>
                            <td>{{ $mem->last_name }}</td>
                            <td>{{ $mem->type }}</td>
                            <td>{{ $mem->joining_date }}</td>
                            <td>{{ $mem->status }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr  class="text-center">
                        <td colspan="5">No Members Available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
