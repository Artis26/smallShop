<?php
namespace App\Services\Products\Show;

use App\Repositories\Products\ProductsRepository;

class ShowProductService {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function execute(ShowProductRequest $request): ShowProductResponse {
        $product = $this->productsRepository->getById($request->getProductId());

        return new ShowProductResponse($product);
    }
}