<?php

namespace App\Factory;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class familyRoomReservationFactory implements ReservationFactoryInterface {
    public function createReservation($reservationData,$customerID) {
        // Add logic to create a reservation for a single room
        $room = Room::findOrFail($reservationData['room_id']);

        // Calculate total price based on room price and number of nights
        $checkIn = Carbon::parse($reservationData['check_in_date']);
        $checkOut = Carbon::parse($reservationData['check_out_date']);
        $numberOfNights = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->pricePerNight * $numberOfNights;

        // Generate a random room number within a range (e.g., 100-999)
        $reservedRoomNumber = rand(0, 100);

        // Create reservation
        $reservation = new Reservation();
        $reservation->customerID = $customerID;
        $reservation->roomID = $reservationData['room_id'];
        $reservation->checkInDate = $reservationData['check_in_date'];
        $reservation->checkOutDate = $reservationData['check_out_date'];
        $reservation->reservedRoomNumber = $reservedRoomNumber;
        $reservation->totalPrice = $totalPrice;
        $reservation->service = $reservationData['room_service'];
        // Add more attributes as needed
        return $reservation;
    }
}