@extends('layouts.main')

@section('title')
Enrollment
@endsection

@section('main-section')
@if (session('success'))
   <div class="alert alert-success">
      {{session('success')}}
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
         <form action="{{ route('enrollment-store') }}" method="post">
            @csrf
            <div class="modal-body">
               <select name="member" class="form-control mt-3" id="">
                  <option value="" disabled selected>Select Member..</option>
                  @foreach ($members as $member)
                 <option value="{{$member->id}}">{{$member->first_name . " " . $member->last_name}}</option>
              @endforeach
               </select>
               <select name="specialization" id="specialization" class="form-control mt-3" id="">
                  <option value="" disabled selected>Select Specialization..</option>
                  @foreach ($specializations as $s)
                 <option value="{{$s->id}}">{{$s->name}}</option>

              @endforeach
               </select>



               <select id="class" name="class" class="form-control mt-3" disabled>
                  <option value="" disabled selected>For Classes, Select Specialization</option>
               </select>

               <input type="date" name="enroll_date" class="form-control mt-3">



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
            <th scope="col">Name</th>
            <th scope="col">Speciality</th>
            <th scope="col">Trainer</th>
            <th scope="col">Days</th>
            <th scope="col">Time</th>
            <th scope="col">Status</th>
         </tr>
      </thead>
      <tbody>
         @if ($enrollments->count()>0)
            @foreach ($enrollments as $e)
            <tr class="">
               <td scope="row">{{$e->first_name." ".$e->last_name}}</td>
               <td>{{$e->specialization_name}}</td>
               <td>{{$e->trainer_name}}</td>
               <td>{{$e->days}}</td>
               <td>{{$e->time}}</td>
               <td class="d-flex justify-content-center">
                  <button type="button" class="mx-1 btn btn-danger open-modal-delete" data-id="{{$e->enrollment_id}}" data-bs-target="#modalDelete" data-bs-toggle="modal">Delete</button>
                  @if ($e->enrollstatus == 'cleared')
                     <button class="btn btn-primary">Cleared</button>
                     @else
                     <button class="btn btn-danger">Pending</button>
                     
                  @endif
               </td>
            </tr>    
            @endforeach
         @else
            <tr>
               <td colspan="6" class="text-center">No Enrollments</td>
            </tr>
         @endif  
      </tbody>
   </table>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDelete">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('enrollment-delete') }}" method="post">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function () {
      $('#specialization').change(function () {
         var specializationId = $(this).val();
         console.log(specializationId);

         if (specializationId) {
            $.ajax({
               url: 'classes/get-classes/' + specializationId,
               type: 'GET',
               success: function (data) {
                  if (data.classes.length > 0) {
                     console.log(data.classes);
                     $('#class').empty(); // Clear existing options
                     $('#class').html('<option value="">Select Class..</option>');
                     $('#class').attr('disabled', false)
                     // Populate classes dropdown
                     $.each(data.classes, function (key, value) {
                        $('#class').append('<option value="' + value.id + '">' + value.trainer_name + ' - ' + value.days + ' - ' + value.time + ' - Starting from: ' + value.start_date + '</option>');
                     });
                  }
                  else {
                     $('#class').empty();
                     $('#class').html('<option>No Classes Available</option>');
                     $('#class').attr('disabled', true);
                  }
               },
               error: function () {
                  alert("Error Fetching Classes");
               }
            });
         }
      });
      $(document).on('click', '.open-modal-delete', function () {
            var id = $(this).attr('data-id'); 
            console.log(id);
            $.ajax({
                url: 'enrollments/get-enrollment/' + id,
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