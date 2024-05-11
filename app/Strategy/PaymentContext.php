<?php
/**
 * @author Whelan Yap Boon Hong
 */
namespace App\Strategy;

class PaymentContext
{
    protected $strategy;

    public function __construct(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function processPayment(array $paymentData)
    {
        return $this->strategy->processPayment($paymentData);
    }
}