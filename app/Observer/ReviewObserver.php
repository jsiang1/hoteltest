<?php

namespace App\Observer;

use App\Models\Review;
use App\Models\Room;
use App\Models\Notification;

class ReviewObserver implements ReviewObserverInterface
{
    public function created(Review $review)
    {

        $room = Room::find($review->roomID);
        $roomType = $room ? $room->roomType : 'Unknown';

        // Create a new notification for admin when a review is created
        Notification::create([
            'type' => 'review',
            'message' => "New review created for room type: {$roomType}",
            'reviewID' => $review->reviewID,
            // Add other necessary attributes
        ]);
    }
}