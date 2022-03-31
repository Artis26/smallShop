<?php
namespace App\Services\Products\Buy\PaymentMethods;

interface PaymentMethod {
    public function pay(float $amount): string;
}