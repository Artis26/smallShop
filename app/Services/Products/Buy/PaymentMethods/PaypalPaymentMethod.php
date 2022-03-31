<?php
namespace App\Services\Products\Buy\PaymentMethods;

class PaypalPaymentMethod implements PaymentMethod {
    private string $email;

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function pay(float $amount): string {
        return "Payed with Paypal | " . "Payer: " . $this->getEmail() . " | " .$amount . '$';
    }

    public function getEmail(): string {
        return $this->email;
    }
}