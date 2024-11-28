@extends('layouts.main')
@section('title')
    Membership
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    $(document).ready(function(){
        $('#specialization').change(function(){
            var specializationId = $(this).val();
            console.log(specializationId);

            $('#trainer').html('<option value="" disabled selected>Loading...</option>');
            $.ajax({
                url: 'trainer/get-trainer/' + specializationId,  // Correct URL structure
                type: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        $('#trainer').attr('disabled', false);  // Enable trainer dropdown
                        $('#trainer').html('<option value="" disabled selected>Select Trainer..</option>'); // Reset trainer options
                        $.each(response, function(key, trainer) {
                            $('#trainer').append('<option value="' + trainer.id + '">' + trainer.name + '</option>');
                        });
                    } else {
                        $('#trainer').attr('disabled', true);  // Disable trainer dropdown if no trainers
                        $('#trainer').html('<option value="" disabled selected>No Trainers Available</option>');
                    }
                },
                error: function() {
                    $('#trainer').attr('disabled', true);  // Disable trainer dropdown on error
                    $('#trainer').html('<option value="" disabled selected>Error loading trainers</option>');  // Show error message
                }
            })
        })
    });
</script> --}}