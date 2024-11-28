@extends('layouts.main')
@section('title')
Members
@endsection
@section('main-section')
    @if (session('success'))
        <div class="alert alert-primary">
            {{session('success')}}
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
                <form action="{{route('members-store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control mt-3" required>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control mt-3" required>
                        <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control mt-3" required>
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control mt-3" required>
                        <input type="text" name="address" id="address" placeholder="Address" class="form-control mt-3" required>

                        <!-- Membership Selection -->
                        <select name="membership_id" id="membership" class="form-control mt-3" required>
                            <option value="">Select Membership..</option>
                            @foreach ($memberships as $m)
                            <option value="{{$m->id}}" data-duration="{{$m->duration}}">{{$m->type}}</option>
                            @endforeach
                        </select>

                        <!-- Start Date -->
                        <input type="date" name="joining_date" id="start_date" class="form-control mt-3" required>

                        <!-- End Date (Calculated via JavaScript) -->
                        <input type="text" name="expiry_date" id="end_date" placeholder="End Date" class="form-control mt-3" readonly>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
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