<?php
/**
 * @author Whelan Yap Boon Hong
 */
namespace App\Strategy;

class PayPalPaymentStrategy implements PaymentStrategy
{
    public function processPayment(array $paymentData)
    {
        // Validate payment data
        if ($this->validatePaymentData($paymentData)) {
            // Logic to process PayPal payment
            return 'success';
        } else {
            return 'failure';
        }
    }

    private function validatePaymentData(array $paymentData): bool
    {
        // Validate cardNumber and cardExp
        $cardNumber = $paymentData['cardNumber'];
        $cardExp = $paymentData['cardExp'];

        // Card number format: xxxx-xxxx-xxxx-xxxx
        if (!preg_match('/^\d{4}-\d{4}-\d{4}-\d{4}$/', $cardNumber)) {
            return false;
        }

        // Card expiration format: MM/YY
        if (!preg_match('/^\d{2}\/\d{2}$/', $cardExp)) {
            return false;
        }

        // Additional validation logic if needed

        return true;
    }
}