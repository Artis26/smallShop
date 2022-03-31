<?php
namespace App\Services\Products\Buy\PaymentMethods;

class PaymentProcessor {
    private PaymentMethod $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function handle(float $amount) {
        //CANT USE $_ JUST A TEST;
        $_SESSION['inputs'] = $this->paymentMethod->pay($amount);
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
    }
}
