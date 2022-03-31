<?php
namespace App\Services\Products\Buy;

use App\Repositories\Products\ProductsRepository;
use App\Services\Products\Buy\PaymentMethods\CreditCardPaymentMethod;
use App\Services\Products\Buy\PaymentMethods\PaymentProcessor;
use App\Services\Products\Buy\PaymentMethods\PaypalPaymentMethod;

class BuyProductService {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function execute(BuyProductRequest $request) {
        $this->productsRepository->buy($request->getProductId(), $request->getAmount());
        $selectedPaymentMethod = $request->getPaymentMethod();

        switch ($selectedPaymentMethod) {
            case 'paypal':
                $paymentMethod = new PaypalPaymentMethod('admin@gmail.com');
                break;
            case 'credit-card':
                $paymentMethod = new CreditcardPaymentMethod('Artis Smirnovs', 99999999, 999);
                break;
            default:
                break;
        }

        (new PaymentProcessor($paymentMethod))->handle($request->getTotalSum());
    }
}