<?php

namespace App\Services\Stripe;

use Stripe\StripeClient;

class StripeProductService
{
    private $stripe;

    public function __construct()
    {
        $apiKey = config('stripe.secret');
        $this->stripe = new StripeClient($apiKey);
    }

    public function createProduct($name, $description)
    {
        return $this->stripe->products->create([
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function createPrice($productId, $unitAmount, $currency)
    {
        return $this->stripe->prices->create([
            'product' => $productId,
            'unit_amount' => $unitAmount,
            'currency' => $currency,
        ]);
    }
}
