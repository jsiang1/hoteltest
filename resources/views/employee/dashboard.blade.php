@extends('employee.layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="w3-container">
            <div class="w3-responsive">
                <h5 class="card-title fw-semibold mb-4">Reservation List</h5>
                <table class="w3-table-all">
                    <tr>
                        <th>Reservation ID</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Room Type</th>
                        <th>Check-in date</th>
                        <th>Check-out date</th>
                        <th>Room Number</th>
                    </tr>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->reservationID }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->user->email }}</td>
                        <td>{{ $reservation->room->roomType }}</td> 
                        <td>{{ $reservation->checkInDate }}</td>
                        <td>{{ $reservation->checkOutDate }}</td>
                        <td>{{ $reservation->reservedRoomNumber }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection