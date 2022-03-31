<?php
namespace App\Services\Products\Index;

use App\Repositories\Products\ProductsRepository;

class IndexProductService {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function execute(): IndexProductResponse {
        return new IndexProductResponse($this->productsRepository->getAll());
    }
}