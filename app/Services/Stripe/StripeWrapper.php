<?php

namespace App\Services\Stripe;

use App\Services\Stripe\Product\StripeProductService;
use Stripe\StripeClient;

class StripeWrapper
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function createProduct(array $params)
    {
        return $this->stripe->products->create($params);
    }

    public function listProducts($params = [])
    {
        return $this->stripe->products->all($params);
    }

    public function productService()
    {
        return new StripeProductService($this);
    }

    public function createPrice(array $params)
    {
        return $this->stripe->prices->create($params);
    }

    // Add other methods as needed...
}
