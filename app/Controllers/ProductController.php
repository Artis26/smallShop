<?php
namespace App\Controllers;

use App\Redirect;

use App\Services\Products\Buy\BuyProductRequest;
use App\Services\Products\Buy\BuyProductService;
use App\Services\Products\Index\IndexProductService;
use App\Services\Products\Show\ShowProductRequest;
use App\Services\Products\Show\ShowProductService;
use App\Services\Products\Store\StoreProductRequest;
use App\Services\Products\Store\StoreProductService;
use App\View;

class ProductController {
    private IndexProductService $indexProductService;
    private StoreProductService $storeProductService;
    private ShowProductService $showProductService;
    private BuyProductService $buyProductService;

    public function __construct(StoreProductService $storeProductService, IndexProductService $indexProductService,
    ShowProductService $showProductService, BuyProductService $buyProductService) {
        $this->storeProductService = $storeProductService;
        $this->indexProductService = $indexProductService;
        $this->showProductService = $showProductService;
        $this->buyProductService = $buyProductService;
    }

    public function show(array $vars): View {
        $productId = $vars['id'];
        $response = $this->showProductService->execute(new ShowProductRequest($productId));

        return new View('Products/show.html', [
            'product'=>$response->getProduct()
        ]);
    }

    public function index(): View {
        $response = $this->indexProductService->execute();

        return new View('Products/index.html', [
            'products'=>$response->getProducts()
        ]);
    }

    public function store(): Redirect {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $count = $_POST['count'];
        $this->storeProductService->execute(new StoreProductRequest($name, $price, $count));

        return new Redirect('/products');
    }

    public function create(): View {
        return new View('Products/create.html');
    }

    public function buy(array $vars): Redirect {
        $productId = $vars['id'];
        $paymentMethod = $_POST['payment'];
        $amount = $_POST['amount'];

        $response = $this->showProductService->execute(new ShowProductRequest($productId));
        $product = $response->getProduct();

        $totalSum = $product->getPrice() * $amount;

        $this->buyProductService->execute(new BuyProductRequest($productId, $amount, $paymentMethod, $totalSum));

        return new Redirect('/product/' . $productId);
    }
}