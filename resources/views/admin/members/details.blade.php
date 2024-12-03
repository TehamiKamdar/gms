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

<!-- Member Details -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Member Details
    </div>
    <div class="card-body">
        <form id="updateForm" action="{{ route('member-update', $details->member_id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label"><strong>First Name:</strong></label>
                        <input type="text" name="first_name" id="first_name" value="{{$details->first_name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label"><strong>Last Name:</strong></label>
                        <input type="text" name="last_name" id="last_name" value="{{$details->last_name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>Contact:</strong></label>
                        <input type="email" name="email" id="email" value="{{$details->email}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="joining_date" class="form-label"><strong>Joining Date:</strong></label>
                        <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date', $details->joining_date) }}"
 disabled class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label"><strong>Address:</strong></label>
                        <input type="text" name="address" id="address" value="{{$details->address}}" class="form-control">
                    </div>
                    <p><strong>Status:</strong>
                        @if($details->payment_status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-success text-dark">Cleared</span>
                        @endif
                    </p>
                </div>
            </div>
        </form>
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

<!-- Buttons for Update and Delete -->
<div class="d-flex justify-content-between mt-3">
    <!-- Update Button -->
    <button type="submit" form="updateForm" class="btn btn-primary">Update</button>
    
    <!-- Delete Button -->
    <form action="{{ route('member-delete', $details->member_id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>

@endsection
