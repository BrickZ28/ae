<?php

namespace App\Services\Stripe;

use Stripe\Stripe;
use Stripe\StripeClient;

class StripeWrapper
{
    private $stripe;

    public function __construct()
{
    $apiKey = config('stripe.secret');
    Stripe::setApiKey($apiKey);
    $this->stripe = new StripeClient($apiKey);
}

    public function createCharge($amount, $currency, $source, $description)
    {
        return $this->stripe->charges->create([
            'amount' => $amount,
            'currency' => $currency,
            'source' => $source,
            'description' => $description,
        ]);
    }

    public function listCharges()
{
    return $this->stripe->charges->all();
}
}
