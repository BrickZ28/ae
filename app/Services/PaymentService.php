<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class PaymentService
{



   public function processPayment($cart, $totalUsd, $totalAec)
{
    if ($totalUsd > 0) {
        return $this->processStripePayment($cart);
    }


    if ($totalUsd === 0 && $totalAec > 0) {

        return redirect(route('dashboard.index'))->with('success', 'AE Credits Deducted');
    }

    return ['status' => 'error', 'message' => 'Transaction Not completed', 'redirectTo' => 'dashboard'];
}

    private function processStripePayment($cart)
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

    private function processAecPayment($totalAec)
    {
        if (!$this->hasEnoughAEC($totalAec)) {
            return ['status' => 'error', 'message' => 'Not enough AE Credits', 'redirectTo' => 'dashboard'];
        }

        return $this->deductAEC($totalAec);
    }

    private function hasEnoughAEC($totalAEC)
    {
        $currentUser = Auth::user(); // Get the currently authenticated user

        if ($currentUser) {
            return $currentUser->ae_credits >= $totalAEC;
        }

        return false;
    }

    private function deductAEC($totalAEC)
    {
        $currentUser = Auth::user(); // Get the currently authenticated user

        if ($currentUser) {
            $currentUser->ae_credits -= $totalAEC;
            return $currentUser->save();
        }

        return false;
    }

    public function handleStripeResponseService($totalAEC, $totalUSD, $cart)
    {
        $msg = 'Payment processed successfully!! ';
        if (!$totalUSD) {
            $msg = ' Stripe Payment Cancelled. ';
        }

        if ($totalAEC > 0) {
            $this->processAecPayment($totalAEC);
            $msg .= ' AE Credits Deducted';
        }

        $order = new Order;
        $order->addCartItems($cart, $totalUSD, $totalAEC);

        $cart->items()->detach();
        $cart->delete();

        // TODO add to transaction both the USD and AECredits payments

        return ['status' => 'success', 'message' => $msg, 'redirectTo' => 'dashboard'];

    }




}
