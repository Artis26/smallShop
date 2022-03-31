<?php
namespace App\Services\Products\Store;

use App\Models\Product;
use App\Repositories\Products\ProductsRepository;

class StoreProductService {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function execute(StoreProductRequest $request) {
        $product = new Product(
            $request->getName(),
            $request->getPrice(),
            $request->getCount()
        );

        $this->productsRepository->store($product);
    }
}