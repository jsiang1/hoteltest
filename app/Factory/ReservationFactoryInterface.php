<?php

namespace App\Factory;

interface ReservationFactoryInterface {
    public function createReservation($reservationData,$customerID);
}