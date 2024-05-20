<?php

namespace App\Services;

use App\Jobs\ProcessTransactionJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentService
{
    private $discordService;


    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function processPayment()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();

        if (!$cart) {
            return ['status' => 'error', 'message' => 'No cart found', 'redirectTo' => 'back'];
        }

        $itemsUSD = $cart->items->where('currency_type', 'USD');

        // Create a Stripe client
        $stripe = new StripeClient(config('services.stripe.secret'));

        // Create a payment intent
        try {
            // Prepare line items for each item in the cart
            $lineItems = $itemsUSD->map(function ($item) {
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

    public function stripePaymentSuccess(Request $request)
    {

        // Get the Stripe payment ID from the request
        $paymentId = $request->get('payment_id');

        // Check if the payment ID is null or whitespace
        if (!$paymentId || trim($paymentId) === '') {
            // Handle the error
            return ['status' => 'error', 'message' => 'Payment ID is missing'];
        }

        // Get the total USD from the request
        $totalUSD = $request->get('total_usd');

        $cart = $this->getCart();
        if (!$cart) {
            $this->notifyAdmin('An order was placed but the user was not found.');
            return $this->redirectToDashboardWithMessage('Payment successful. An admin will fill your order within 24 hours');
        }

        $totalAEC = $this->calculateTotalAEC($cart);

        $user = $this->getUser();
        if (!$user || !$this->hasEnoughAEC($user, $totalAEC)) {
            return $this->redirectToDashboardWithMessage('There was an error processing your order. Please try again.');
        }

        $this->processOrder($user, $cart, $totalAEC, $totalUSD);

        $this->notifyAdmin('New order has been placed. Please fill the order within 24 hours.');

        return $this->redirectToDashboardWithMessage('Payment successful. AEC credits deducted successfully.  An admin will fill your order within 24 hours');
    }

    private function getCart()
    {
        return Cart::where('user_id', auth()->id())->with('items')->first();
    }

    private function notifyAdmin($message)
    {
        $this->discordService->sendMessage('190198403420913674', $message);
    }

    private function redirectToDashboardWithMessage($message)
    {
        return view('dashboard.index', ['message' => $message]);
    }

    private function calculateTotalAEC($cart)
    {
        return $cart->items->where('currency_type', 'AEC')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);
    }

    private function getUser()
    {
        return auth()->user();
    }

    private function hasEnoughAEC($user, $totalAEC)
    {
        return $user->ae_credits >= $totalAEC;
    }

    private function processOrder($user, $cart, $totalAEC, $totalUSD)
    {
        $user->ae_credits -= $totalAEC;
        $user->save();

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_contents' => $cart->items->toJson(),
        ]);

        $cart->items()->detach();

        // Retrieve the server owner's ID
        $serverOwner = User::whereIn('discord_id', [138792121564921856, 190198403420913674])->first();

        if ($serverOwner) {
            // Dispatch the job to create a transaction for ae_credits if the totalAEC is more than 0
            if ($totalAEC > 0) {
                ProcessTransactionJob::dispatch($user->id, $serverOwner->id, $totalAEC, 'Payment for order id ' . $order->id);
            }
            // Dispatch the job to create a transaction for sUSD if the user has sUSD and it's more than 0
            if ($totalUSD > 0) {
                ProcessTransactionJob::dispatch($user->id, $serverOwner->id, $totalUSD, 'Payment for order id ' . $order->id);
            }
        }
    }

    public function stripePaymentCancel()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return $this->redirectToDashboardWithMessage('No items in cart.');
        }

        $aecItems = $this->getAECItems($cart);
        $totalAEC = $this->calculateTotalAEC($aecItems);

        $user = $this->getUser();
        if (!$this->hasEnoughAEC($user, $totalAEC)) {
            return $this->redirectToDashboardWithMessage('Not enough AEG credits.');
        }

        $this->processCancellation($user, $cart, $aecItems, $totalAEC);

        return $this->redirectToInvoiceWithMessage('Payment cancelled. AEC credits deducted successfully. An admin will fill your order within 24 hours');
    }

    private function getAECItems($cart)
    {
        return $cart->items->where('currency_type', 'AEC');
    }

    private function processCancellation($user, $cart, $aecItems, $totalAEC)
    {
        $this->deductAEC($user, $totalAEC);
        $this->storeCancellationOrder($user, $aecItems);
        $this->removeAECItemsFromCart($cart, $aecItems);
    }

    private function deductAEC($user, $totalAEC)
    {
        $user->ae_credits -= $totalAEC;
        $user->save();
    }

    private function storeCancellationOrder($user, $aecItems)
    {
        Order::create([
            'user_id' => $user->id,
            'items' => $aecItems->toJson(),
            'total' => $aecItems->sum('price'),
        ]);
    }

    private function removeAECItemsFromCart($cart, $aecItems)
    {
        $cart->items()->whereIn('id', $aecItems->pluck('id'))->detach();
    }

    private function redirectToInvoiceWithMessage($message)
    {
        return view('invoice', ['message' => $message]);
    }

    public function cancelCheckout()
    {
        return ['status' => 'error', 'message' => 'Checkout Cancelled', 'redirectTo' => 'dashboard'];

    }
}
