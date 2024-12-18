@extends('layouts.main')
@section('title')
Member
@endsection
@section('main-section')
@if (session('success'))
    <div class="alert alert-primary">
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
<div class="d-flex justify-content-between">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add New @yield('title')
    </button>
    <!-- Search Form -->
    <form method="GET" action="{{route('members-search')}}" class="d-flex">
        <input type="text" name="query" class="form-control" placeholder="Search Members..." value="{{ request()->query('query') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('members-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="first_name" id="first_name" placeholder="First Name"
                        class="form-control mt-3" required>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control mt-3"
                        required>
                    <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control mt-3" required>
                    <input type="email" name="email" id="email" placeholder="Email" class="form-control mt-3" required>
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
                    <input type="date" name="start_date" id="start_date" class="form-control mt-3" required>

                    <!-- End Date (Calculated via JavaScript) -->
                    <input type="text" name="end_date" id="end_date" placeholder="End Date" class="form-control mt-3"
                        readonly>

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
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Membership</th>
                <th scope="col">Joining Date</th>
                <th scope="col">Ending Date</th>
                <th colspan="2" class="text-center">Status</th>
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
                        <td>{{ $mem->expiry_date }}</td>
                        <td>
                            @if ($mem->status == 'pending')
                                <a href="{{route('payment-index')}}" class="btn btn-outline-danger">Pending</a>
                            @else
                                <button class="btn btn-success">Active</button>
                            @endif
                        </td>
                        <td><a href="{{route('member-details', $mem->id)}}" class="btn btn-outline-secondary">Details</a></td>

                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="6">No Members Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // When membership or start date changes
    $('#membership, #start_date').on('change', function() {
        var membershipId = $('#membership').val(); // Get selected membership ID
        var startDate = $('#start_date').val(); // Get selected start date

        // Ensure both are selected
        if (membershipId && startDate) {
            // Get the duration (in days) for the selected membership
            var duration = $('#membership option:selected').data('duration');

            // If duration is found
            if (duration) {
                // Calculate the end date
                var start = new Date(startDate); // Convert start date string to date object
                start.setDate(start.getDate() + duration); // Add the duration in days

                // Format the end date as YYYY-MM-DD
                var endDate = start.toISOString().split('T')[0];

                // Set the calculated end date in the end_date input field
                $('#end_date').val(endDate);
            } else {
                $('#end_date').val(''); // If no duration, clear the end date
            }
        }
    });
});

</script>