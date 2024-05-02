<?php

namespace App\Factory;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class ReservationFactory
{
    public static function createReservation($roomType, $customerID, $checkInDate, $checkOutDate)
    {
        // Map room type to room ID
        $roomIds = [
            'single' => 1,
            'deluxe' => 2,
            'family' => 3,
        ];

        // Retrieve the corresponding room ID
        $roomID = $roomIds[$roomType];

        // Retrieve the room based on the provided room ID
        $room = Room::findOrFail($roomID);

        // Generate a random room number within a range (e.g., 100-999)
        $reservedRoomNumber = rand(100, 999);

        // Calculate total price based on room price and number of nights
        $checkIn = Carbon::parse($checkInDate);
        $checkOut = Carbon::parse($checkOutDate);
        $numberOfNights = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->pricePerNight * $numberOfNights;

        // Create reservation
        $reservation = new Reservation();
        $reservation->customerID = $customerID;
        $reservation->roomID = $roomID;
        $reservation->checkInDate = $checkInDate;
        $reservation->checkOutDate = $checkOutDate;
        $reservation->reservedRoomNumber = $reservedRoomNumber;
        $reservation->totalPrice = $totalPrice;
        $reservation->save();

        return $reservation;
    }
}