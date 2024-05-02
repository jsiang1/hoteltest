<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use App\Factory\ReservationFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function showForm()
    {
        // Retrieve room types from the database
        $roomTypes = Room::pluck('roomType');
        $roomTypes = $this->parseRoomTypes();

        return view('home.reservations', ['roomTypes' => $roomTypes]);

        
    }

    private function parseRoomTypes()
    {
        // Load the XML file from the app/XML directory
        $xmlPath = app_path('XML/room_types.xml');
        $xmlString = file_get_contents($xmlPath);
        $xml = new SimpleXMLElement($xmlString);

        // Extract room types
        $roomTypes = [];
        foreach ($xml->room_type as $type) {
            $roomTypes[] = (string) $type;
        }

        return $roomTypes;
    }

    public function submitForm(Request $request)
    {
        // Validate the input
        $request->validate([
            'room_type' => 'required|in:single,deluxe,family',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
        ]);

        // Store the reservation details in session
        $request->session()->put('reservation', $request->all());

        // Redirect to the payment page
        return redirect()->route('payment');
    }

    public function makeReservation(Request $request)
    {
        // Get the reservation details from session
        $reservationData = $request->session()->get('reservation');

        // Get customer ID from session (assuming it's stored after user login)
        $customerID = auth()->user()->id;

        // Create the reservation using the ReservationFactory
        ReservationFactory::createReservation(
            $reservationData['room_type'],
            $customerID,
            $reservationData['check_in_date'],
            $reservationData['check_out_date']
        );

        // Clear the reservation details from session
        $request->session()->forget('reservation');

        // Redirect back with success message or do anything else
        return redirect()->back()->with('success', 'Reservation made successfully!');
    }
}
