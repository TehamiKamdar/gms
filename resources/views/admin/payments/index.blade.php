@extends('layouts.main')

@section('title')
    Payments
@endsection

@section('main-section')
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Pending Amount</th>
                    <th scope="col">Last Paid</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                @if ($payments->count() > 0)
                    @foreach ($payments as $p)
                        <tr class="">
                            <td>{{$p->first_name." ".$p->last_name}}</td>
                            <td>{{$p->total_amount}}</td>
                            <td>{{$p->paid_amount}}</td>
                            <td>{{$p->total_amount - $p->paid_amount}}</td>
                            <td>{{$p->payment_date ?? 'No Data Available'}}</td>
                            <td><a href="{{route('payment-details', $p->id)}}" class="btn btn-outline-secondary">Details</a></td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="5" class="text-center">No Payments Record Available.</td>
                        </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
