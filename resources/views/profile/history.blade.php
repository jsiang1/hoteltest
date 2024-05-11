<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservation History') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w3-container">
                    <div class="w3-responsive">
                        <table class="w3-table-all">
                            <tr>
                                <th>Reservation ID</th>
                                <th>Room Type</th>
                                <th>Check-in Date</th>
                                <th>Check-out Date</th>
                                <th>Room Number</th>
                                <th>Total Price</th>
                            </tr>
                            <tr>
                                @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->reservationID }}</td>
                                <td>{{ $reservation->room->roomType }}</td> 
                                <td>{{ $reservation->checkInDate }}</td>
                                <td>{{ $reservation->checkOutDate }}</td>
                                <td>{{ $reservation->reservedRoomNumber }}</td>
                                <td>{{ $reservation->totalPrice }}</td>
                                @if(!$reservation->reviewExists())
            <td><a href="{{ route('profile.writereview',['reservationID' => $reservation->reservationID]) }}" class="w3-button w3-blue w3-small">Write Review</a></td>
            @else
            <td>review submitted</td>
        @endif
                                
                                <!-- Add more columns as needed -->
                            </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>