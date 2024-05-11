<?php
/**
 * @author Whelan Yap Boon Hong
 */
namespace App\Strategy;

interface PaymentStrategy
{
    public function processPayment(array $paymentData);
}