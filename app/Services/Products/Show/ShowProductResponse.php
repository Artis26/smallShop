<?php
namespace App\Services\Products\Show;

use App\Models\Product;

class ShowProductResponse {
    private Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function getProduct(): Product {
        return $this->product;
    }
}