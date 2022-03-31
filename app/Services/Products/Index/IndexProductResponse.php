<?php
namespace App\Services\Products\Index;

class IndexProductResponse {
    private array $products;

    public function __construct(array $products) {
        $this->products = $products;
    }

    public function getProducts(): array {
        return $this->products;
    }
}