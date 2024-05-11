<?php

namespace App\Observer;

use App\Models\Review;

interface ReviewObserverInterface
{
    public function created(Review $review);
}