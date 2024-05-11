<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use SimpleXMLElement;
use DOMDocument;
use DOMXPath;



class ReviewController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve all reviews
        $reviews = Review::with('room')->get();
        $roomTypes = Room::pluck('roomType')->unique(); // Retrieve unique room types

        // Store all reviews in session
        session()->put('all_reviews', $reviews);

        // Load XML file
        $xmlData = file_get_contents(app_path('XML/reviews.xml'));
        $xml = new DOMDocument();
        $xml->loadXML($xmlData);

        // Create XPath instance
        $xpath = new DOMXPath($xml);

        // Retrieve room types
        $roomTypes = $this->getRoomTypes($xpath);
        $rates = $this->getRates($xpath);

        return view('home.review', compact('reviews', 'roomTypes','rates'));
    }

    private function getRoomTypes($xpath)
    {
        $roomTypes = [];
        $nodes = $xpath->query('//review/room');
        foreach ($nodes as $node) {
            $roomTypes[] = $node->nodeValue;
        }
        return $roomTypes;
    }

    private function getRates($xpath)
    {
        $rates = [];
        $nodes = $xpath->query('//rate');
        foreach ($nodes as $node) {
            $rates[] = $node->nodeValue;
        }
        return $rates;
    }

    public function filter(Request $request)
    {
        $filteredReviews = Review::when($request->filled('roomType'), function ($query) use ($request) {
            return $query->whereHas('room', function ($subquery) use ($request) {
                $subquery->where('roomType', $request->roomType);
            });
        })->when($request->filled('rate'), function ($query) use ($request) {
            return $query->where('rate', $request->rate);
        })->get();

        return view('home.filterresult', compact('filteredReviews'));
    }

    public function showReviewForm($reservationID)
{
    // Retrieve roomID using $reservationID
    $roomID = Reservation::findOrFail($reservationID)->roomID;

    $rates = $this->parseRate();

    return view('profile.writereview', ['roomID' => $roomID,'reservationID' => $reservationID],['rates' => $rates]);
}

private function parseRate()
    {
        // Load the XML file from the app/XML directory
        $xmlPath = app_path('XML/reviews.xml');
        $xmlString = file_get_contents($xmlPath);
        $xml = new SimpleXMLElement($xmlString);

        // Extract room types
        $rates = [];
        foreach ($xml->rate as $rate) {
            $rates[] = [
                'id' => (string) $rate['id'],
                'name' => (string) $rate,
            ];
        }

        return $rates;
    }

    public function submitReview(Request $request)
    {

        $request->validate([
            'reservationID'=> 'required|exists:reservations,reservationID',
            'roomID' => 'required|exists:rooms,roomID',
            'rate' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        Review::create([
            'reservationID'=> $request->reservationID,
            'roomID' => $request->roomID,
            'rate' => $request->rate,
            'comment' => $request->comment,
        ]);

        // Notify admin about the new review (you can implement this using notifications)

        return redirect()->route('profile.history');
    }
    
}
