@extends('employee.layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="w3-container">
            <div class="w3-responsive">
                <h5 class="card-title fw-semibold mb-4">Review Notification</h5>
                    <table class="w3-table-all">
                        <tr>
                        <th>Payment ID</th>
                        <th>Reservation ID</th>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Total Price</th>
                        </tr>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->paymentID }}</td>
                            <td>{{ $payment->reservation->reservationID }}</td>
                            <td>{{ $payment->date }}</td>
                            <td>{{ $payment->paymentMethod }}</td>
                            <td>{{ $payment->reservation->totalPrice }}</td>
                        </tr>
                        @endforeach
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection