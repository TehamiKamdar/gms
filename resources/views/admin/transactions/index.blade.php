@extends('layouts.main')


@section('title')
Transaction
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
         <form action="{{route('transaction-store')}}" method="post">
            @csrf
            <div class="modal-body">
               <select name="member" id="member" class="form-control">
                  <option value="" selected disabled>Select Member</option>
                  @foreach ($members as $m)
                 <option value="{{$m->member_id}}">{{$m->first_name . " " . $m->last_name}}</option>
              @endforeach
               </select>

               <input type="text" name="description" id="" placeholder="Reason for Payment" class="form-control mt-3">

               <input type="text" name="amount" id="amount" placeholder="Amount" class="form-control mt-3">

               <select name="method" id="method" class="form-control mt-3">
                  <option value="cash" selected disabled>Select Payment Method</option>
                  <option value="cash">Cash</option>
                  <option value="online">Online</option>
               </select>

               <input type="date" name="payment_date" value="{{now()->format('Y-m-d')}}" class="form-control mt-3">
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
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">M.O.P</th>
            <th scope="col">Pay Date</th>
         </tr>
      </thead>
      <tbody>
         @if ($transactions->count()>0)
            @foreach ($transactions as $t)
               <tr class="">
                  <td scope="row">{{$t->first_name.' '.$t->last_name}}</td>
                  <td>{{$t->description}}</td>
                  <td>{{$t->amount}}</td>
                  <td>{{ucwords($t->payment_mode)}}</td>
                  <td>{{$t->payment_date}}</td>
               </tr>
            @endforeach            
         @else
            <tr>
               <td colspan="6" class="text-center">No Transactions to show.</td>
            </tr>
         @endif
      </tbody>
   </table>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
      $('#method').on('change', function () {
         if ($(this).val() === 'online') {
            $('#referrence_id').prop('disabled', false); // Enable referral input
         } else {
            $('#referrence_id').prop('disabled', true).val(''); // Disable referral input and clear value
         }
      });

      $('#member').on('change', function () {
         var memberId = $(this).val();
         console.log(memberId);

         $.ajax({
            url: 'transactions/get-member/' + memberId,
            method: 'GET',
            success: function (response) {

               var remainingAmount = response.total_amount - response.paid_amount;
               console.log(remainingAmount);
               $('#amount').val(remainingAmount);

            },
            error: function () {
               alert('Error Fetching Amount');
            }
         })
      });
   });

</script>