<?php

namespace App\Services;

use App\Jobs\ProcessTransactionJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class PaymentService
{

    private $currentUser;


    public function __construct()
    {
        $this->currentUser = Auth::user();
    }

    public function processPayment($cart, $totalUsd, $totalAec)//these are session variables
    {

        if ($totalAec > 0 && $totalUsd == 0) {
            if (!$this->hasEnoughAEC($totalAec)) {
                return ['status' => 'error', 'message' => 'Not enough AE Credits', 'redirectTo' => 'back'];
            }
           return $this->deductAEC($totalAec);
        }

        if ($totalUsd > 0 && $totalAec == 0) {
            // Redirect to Stripe for payment
            return $this->processStripePayment($cart, $totalUsd);
        }

        if ($totalAec > 0 && $totalUsd > 0) {
            // Redirect to Stripe for payment
            $stripeResult = $this->processStripePayment($cart, $totalUsd);
            if ($stripeResult['status'] === 'success') {
                if (!$this->hasEnoughAEC($totalAec)) {
                    return ['status' => 'error', 'message' => 'Not enough AEC credits.'];
                }
                $this->deductAEC($totalAec);
            }
        }
    }

    private function processStripePayment($cart, $totalUsd)
{
    // Create a Stripe client
    $stripe = new StripeClient(config('services.stripe.secret'));

    // Create a payment intent
    try {
        // Prepare line items for each item in the cart
        $lineItems = $cart->items->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price * 100, // Stripe requires the amount in cents
                ],
                'quantity' => $item->pivot->quantity,
            ];
        })->values()->toArray(); // Reset the keys to be sequential starting from 0

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('stripe/success'), // Replace with your success route
            'cancel_url' => url('stripe/cancel'), // Replace with your cancel route
        ]);

        return redirect($checkout_session->url);
    } catch (Exception $e) {
        return back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}



    private function hasEnoughAEC($totalAEC)
    {
        return $this->currentUser >= $totalAEC;
    }


    private function deductAEC($totalAEC)
    {
        $this->currentUser->ae_credits -= $totalAEC;
        return $this->currentUser->save();
    }


}
