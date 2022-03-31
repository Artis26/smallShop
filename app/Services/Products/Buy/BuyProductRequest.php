<?php
namespace App\Services\Products\Buy;

class BuyProductRequest {
    private int $productId;
    private int $amount;
    private string $paymentMethod;
    private float $totalSum;

    public function __construct(int $productId, int $amount, string $paymentMethod, float $totalSum) {
        $this->productId = $productId;
        $this->amount = $amount;
        $this->paymentMethod = $paymentMethod;
        $this->totalSum = $totalSum;
    }

    public function getProductId(): int {
        return $this->productId;
    }

    public function getAmount(): int {
        return $this->amount;
    }

    public function getPaymentMethod(): string {
        return $this->paymentMethod;
    }

    public function getTotalSum(): float {
        return $this->totalSum;
    }
}