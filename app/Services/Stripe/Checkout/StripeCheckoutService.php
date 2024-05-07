<?php

namespace App\Services\Stripe\Checkout;


use App\Services\Stripe\StripeWrapper;

class StripeCheckoutService
{

    private $stripeWrapper;

    public function __construct(StripeWrapper $stripeWrapper)
    {
        $this->stripeWrapper = $stripeWrapper;
    }

    public function createCheckoutSession($cart)
    {
        $lineItems = [];

        foreach ($cart->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price * 100, // Stripe requires the amount in cents
                ],
                'quantity' => $item->pivot->quantity,
            ];
        }

        $session = $this->stripeWrapper->checkout()->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
        ]);

        return $session->url;
    }

}
