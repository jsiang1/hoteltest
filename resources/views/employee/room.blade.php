@extends('employee.layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="w3-container">
            <div class="w3-responsive">
                <h5 class="card-title fw-semibold mb-4">Room List</h5>
                    <table class="w3-table-all">
                        <tr>
                            <th>Room ID</th>
                            <th>Room Type</th>
                            <th>Price Per Night</th>
                        </tr>
                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->roomID }}</td>
                            <td>{{ $room->roomType }}</td>
                            <td>{{ $room->pricePerNight }}</td>
                            <td><a href="{{ route('employee.room.edit', $room) }}" class="w3-button w3-blue w3-small">Edit</a></td>
                        </tr>
                        @endforeach
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection