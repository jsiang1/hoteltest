<?php
/**
 * @author Lee Kong Hang
 */
namespace App\Factory;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class ReservationFactory
{
    public static function createReservation($roomID, $customerID, $checkInDate, $checkOutDate, $service)
{
    // Retrieve the room details based on the provided room ID
    $room = Room::findOrFail($roomID);

    // Generate a random room number within a range (e.g., 100-999)
    $reservedRoomNumber = rand(0, 100);

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
    $reservation->service = $service;
    $reservation->save();

    return $reservation;
}
}