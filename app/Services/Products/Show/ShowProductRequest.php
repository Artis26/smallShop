<?php
namespace App\Services\Products\Show;

class ShowProductRequest {
    private int $productId;

    public function __construct(int $productId) {
        $this->productId = $productId;
    }

    public function getProductId(): int {
        return $this->productId;
    }
}