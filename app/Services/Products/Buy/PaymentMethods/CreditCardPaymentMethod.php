<?php
namespace App\Services\Products\Buy\PaymentMethods;

class CreditCardPaymentMethod implements PaymentMethod {
    private string $personNameSurname;
    private int $cardNumber;
    private int $cvc;

    public function __construct(string $personNameSurname, int $cardNumber, int $cvc) {
        $this->personNameSurname = $personNameSurname;
        $this->cardNumber = $cardNumber;
        $this->cvc = $cvc;
    }

    public function pay(float $amount): string {
        return "Payed with CreditCard | " . "Payer: " . $this->getPersonNameSurname() . " | " .$amount . '$';
    }

    public function getPersonNameSurname(): string {
        return $this->personNameSurname;
    }

    public function getCardNumber(): int {
        return $this->cardNumber;
    }

    public function getCvc(): int {
        return $this->cvc;
    }
}