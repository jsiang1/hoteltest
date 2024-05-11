<?php
/**
 * @author Pang Jin Siang
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Review;
class RoomController extends Controller
{
    public function index()
    {
    $rooms = Room::all();
    return view('employee.room', compact('rooms'));
    }

    public function edit(Room $room)
    {
        return view('employee.editroom', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'pricePerNight' => 'required|numeric',
        ]);

        $room->update([
            'pricePerNight' => $request->input('pricePerNight'),
        ]);

        return redirect()->route('employee.successedit')->with('success', 'Room price updated successfully');
    }

    public function showRooms()
{
    $singleRoom = Room::where('roomType', 'single')->first();
    $deluxeRoom = Room::where('roomType', 'deluxe')->first();
    $familyRoom = Room::where('roomType', 'family')->first();

    return view('home.rooms', compact('singleRoom', 'deluxeRoom', 'familyRoom'));
}

public function showSingleRoom()
{
    $singleRoom = Room::where('roomType', 'single')->first();
    $deluxeRoom = Room::where('roomType', 'deluxe')->first();
    $familyRoom = Room::where('roomType', 'family')->first();
    $reviews = Review::where('roomID', $singleRoom->roomID)->get();

    return view('home.singleroom', compact('singleRoom', 'deluxeRoom', 'familyRoom', 'reviews'));
}

public function showDeluxeRoom()
{
    $singleRoom = Room::where('roomType', 'single')->first();
    $deluxeRoom = Room::where('roomType', 'deluxe')->first();
    $familyRoom = Room::where('roomType', 'family')->first();
    $reviews = Review::where('roomID', $deluxeRoom->roomID)->get();

    return view('home.deluxeroom', compact('singleRoom', 'deluxeRoom', 'familyRoom', 'reviews'));
}

public function showFamilyRoom()
{
    $singleRoom = Room::where('roomType', 'single')->first();
    $deluxeRoom = Room::where('roomType', 'deluxe')->first();
    $familyRoom = Room::where('roomType', 'family')->first();
    $reviews = Review::where('roomID', $familyRoom->roomID)->get();

    return view('home.familyroom', compact('singleRoom', 'deluxeRoom', 'familyRoom', 'reviews'));
}
}
