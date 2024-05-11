<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Factory\ReservationFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function showForm()
    {
        // Retrieve room types from the database
        $rooms = $this->parseRoomTypes();

        return view('home.reservations', ['rooms' => $rooms]);

    }

    private function parseRoomTypes()
    {
        // Load the XML file from the app/XML directory
        $xmlPath = app_path('XML/room_types.xml');
        $xmlString = file_get_contents($xmlPath);
        $xml = new SimpleXMLElement($xmlString);

        // Extract room types
        $rooms = [];
        foreach ($xml->room as $room) {
            $rooms[] = [
                'id' => (string) $room['id'],
                'name' => (string) $room,
            ];
        }

        return $rooms;
    }

    public function submitReservation(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // If not authenticated, redirect to the login page
            return redirect()->route('login')->with('error', 'Please log in to make a reservation.');
        }
        
        // Validate the input
        $request->validate([
            'room_id' => 'required|in:1,2,3',
            'check_in_date' => '',
            'check_out_date' => '',
        ]);

        $roomID = $request->input('room_id');
        $room = Room::find($roomID);

         // Calculate the total price based on the room type and the number of nights
        $checkInDate = Carbon::parse($request->input('check_in_date'));
        $checkOutDate = Carbon::parse($request->input('check_out_date'));
        $numberOfNights = $checkInDate->diffInDays($checkOutDate);
        $totalPrice = $room->pricePerNight * $numberOfNights;

        // Store the reservation details in the session
        $request->session()->put('reservation', [
        'room_id' => $roomID,
        'check_in_date' => $checkInDate->format('Y-m-d'),
        'check_out_date' => $checkOutDate->format('Y-m-d'),
        'totalPrice' => $totalPrice,
        ]);

        // Redirect to the payment page
        return redirect()->route('payment_page');
    }

    public function makeReservation(Request $request)
    {

    // Retrieve the reservation data from the request
    $reservationData = $request->session()->get('reservation');

    // Get customer ID from session (assuming it's stored after user login)
    $customerID = auth()->user()->id;

    // Create the reservation using the ReservationFactory
    ReservationFactory::createReservation(
        $reservationData['room_id'],
        $customerID,
        $reservationData['check_in_date'],
        $reservationData['check_out_date']
    );

    // Clear the reservation details from session
    $request->session()->forget('reservationData');

        // Redirect back with success message or do anything else
        return redirect()->route('insert_payment');
    }

    public function index()
    {
        $reservations = Reservation::all();
        return view('employee.dashboard', ['reservations' => $reservations]);
    }
}
