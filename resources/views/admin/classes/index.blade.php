@extends('layouts.main')
@section('title')
Class
@endsection
@section('main-section')
    @if (session('success'))
        <div class="alert alert-success">
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
                <h5 class="modal-title" id="exampleModalLabel">Add New @yield('title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('classes-store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Specialization Dropdown -->
                    <select name="exercise" class="form-control mt-3" id="specialization" required>
                        <option value="" disabled selected>Select Specialization..</option>
                        @foreach ($specializations as $specialization)
                            <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                        @endforeach
                    </select>

                    <!-- Trainers Dropdown -->
                    <select name="trainer_id" id="trainer" class="form-control mt-3" disabled required>
                        <option value="">For Trainers..Select Specialization First</option>
                    </select>

                    <!-- Start Time -->
                    <input type="date" title="Starting Date" name="start_date" class="form-control mt-3" required>

                    <!-- End Time -->
                    <input type="date" title="Ending Date" name="end_date" class="form-control mt-3" required>

                    <!-- Days Dropdown -->
                    <select name="days" id="days" class="form-control mt-3" required>
                        <option value="MWF">Monday - Wednesday - Friday</option>
                        <option value="TTS">Tuesday - Thursday - Saturday</option>
                    </select>

                    <select name="time" id="time" class="form-control mt-3" required>
                        <option value="9AM - 11AM">9AM - 11AM</option>
                        <option value="11AM - 01PM">11AM - 01PM</option>
                        <option value="01PM - 03PM">01PM - 03PM</option>
                        <option value="03PM - 05PM">03PM - 05PM</option>
                        <option value="05PM - 07PM"> 05PM - 07PM</option>
                    </select>

                    <!-- Capacity Input -->
                    <input type="number" class="form-control mt-3" name="capacity"
                        placeholder="Max Participants (e.g., 20)" min="1" required>

                    <!-- Fees Input -->
                    <input type="number" class="form-control mt-3" name="fees" placeholder="Class Fee (e.g., 500)"
                        min="0" step="0.01" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="table-responsive mt-3">
    <table class="table table-primary">
        <thead>
            <tr>
                <th scope="col">Class Of</th>
                <th scope="col">Trainer</th>
                <th scope="col">Days</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Capacity</th>
            </tr>
        </thead>
        <tbody>
            @if ($classes->count() > 0)
            @foreach ($classes as $c)
               <tr>
                <td>{{$c->name}}</td>
                <td>{{$c->trainer_name}}</td>
                <td>{{$c->days}}</td>
                <td>{{$c->start_date}}</td>
                <td>{{$c->end_date}}</td>
                <td>{{$c->capacity}}</td>
               </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No Classes Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#specialization').change(function () {
            var specializationId = $(this).val();
            console.log(specializationId);

            $('#trainer').html('<option value="" disabled selected>Loading...</option>');
            $.ajax({
                url: 'trainer/get-trainer-spec/' + specializationId,  // Correct URL structure
                type: 'GET',
                success: function (response) {
                    if (response.length > 0) {
                        $('#trainer').attr('disabled', false);  // Enable trainer dropdown
                        $('#trainer').html('<option value="" disabled selected>Select Trainer..</option>'); // Reset trainer options
                        $.each(response, function (key, trainer) {
                            $('#trainer').append('<option value="' + trainer.id + '">' + trainer.name + '</option>');
                        });
                    } else {
                        $('#trainer').attr('disabled', true);  // Disable trainer dropdown if no trainers
                        $('#trainer').html('<option value="" disabled selected>No Trainers Available</option>');
                    }
                },
                error: function () {
                    $('#trainer').attr('disabled', true);  // Disable trainer dropdown on error
                    $('#trainer').html('<option value="" disabled selected>Error loading trainers</option>');  // Show error message
                }
            })
        })
    });
</script>