<?php
namespace App\Services\Products\Store;

class StoreProductRequest {
    private string $name;
    private float $price;
    private int $count;

    public function __construct(string $name, float $price, int $count) {
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getCount(): int {
        return $this->count;
    }
}