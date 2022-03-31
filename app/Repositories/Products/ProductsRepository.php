<?php
namespace App\Repositories\Products;

use App\Models\Product;

interface ProductsRepository {
    public function getById(int $productId): Product;
    public function store(Product $product): void;
    public function getAll(): array;
    public function buy(int $productId, int $amount): void;
}