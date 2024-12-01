@extends('layouts.main')

@section('title')
Payment Details
@endsection

@section('main-section')
@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Member Details
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{$details->first_name . " " . $details->last_name}}</p>
                <p><strong>Member ID:</strong> {{$details->member_id}}</p>
                <p><strong>Contact:</strong> {{$details->email}}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Joining Date:</strong> {{$details->joining_date}}</p>
                <p><strong>Address:</strong> {{$details->address}}</p>
                <p><strong>Status:</strong>
                    @if($details->payment_status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-success text-dark">Cleared</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Membership Details -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        Membership Details
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Membership Type:</strong> {{$details->type}}</p>
                <p><strong>Start Date:</strong> {{$details->joining_date}}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Expiry Date:</strong> {{$details->expiry_date}}</p>
                <p><strong>Duration:</strong> {{$details->duration}} Days</p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Details -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        Payment Details
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Total Fee:</strong> {{$details->total_amount}}</p>
                <p><strong>Amount Paid:</strong> {{$details->paid_amount}}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Pending Amount:</strong> {{$details->total_amount - $details->paid_amount}}</p>
                <p><strong>Payment History:</strong></p>
                <ul>
                    <li>No Payment History Available</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Payment Processing -->
{{--<div class="card">
    <div class="card-header bg-secondary text-white">
        Process Payment
    </div>
    <div class="card-body">
        <form action="{{route('update-payment', $details->member_id)}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount to Pay</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount">
            </div>
            <div class="mb-3">
                <label for="paymentMode" class="form-label">Payment Mode</label>
                <select class="form-select" id="paymentMode" name="paymentMode">
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="Online">Online</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="referralCode" class="form-label">Referral Code</label>
                <input type="text" id="referralCode" name="referralCode" class="form-control"
                    placeholder="Enter Referral Code" disabled>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Payment</button>
        </form>
    </div>
</div>--}}
@endsection
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#paymentMode').on('change', function () {
            if ($(this).val() === 'Online') {
                $('#referralCode').prop('disabled', false); // Enable referral input
            } else {
                $('#referralCode').prop('disabled', true).val(''); // Disable referral input and clear value
            }
        });
    });

</script> -->