<?php

namespace App\Strategy;

interface PaymentStrategy
{
    public function processPayment(array $paymentData);
}