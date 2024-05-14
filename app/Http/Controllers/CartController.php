<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Services\CartService;
use App\Services\DiscordService;
use App\Services\Stripe\StripeWrapper;
use Exception;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class CartController extends RedirectController
{
    private $discordService;
    private $cartService;

    public function __construct(DiscordService $discordService, CartService $cartService)
    {
        $this->discordService = $discordService;
        $this->cartService = $cartService;
    }


    public function index()
    {

    }

    public function store(Request $request)
    {
        return $this->handleServiceResult($this->cartService->cartServiceStore($request));
    }

    public function show()
    {
        return $this->cartService->cartServiceShow();
    }

    public function edit(Cart $cart)
    {
    }

    public function update(Request $request, Cart $cart)
    {
    }

    public function destroy($id)
    {
       return $this->cartService->cartDestroyService($id);
    }

    public function updateQuantity($id, Request $request)
    {
        // Retrieve the cart
        $cart = Cart::where('user_id', auth()->id())->first();

        // Check if the cart exists
        if (!$cart) {
            return back()->with('error', 'No Cart found.');
        }

        // Retrieve the item
        $item = Item::find($id);

        // Check if the item exists
        if (!$item) {
            return back()->with('error', 'No Item found.');
        }

        // Update the quantity of the item in the cart
        $cart->items()->updateExistingPivot($item->id, ['quantity' => $request->quantity]);

        return back()->with('success', 'Item quantity updated successfully.');
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();

        if (!$cart) {
            return back()->with('error', 'No items in cart.');
        }

        $totalUSD = $cart->items->where('currency_type', 'USD')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        $totalAEC = $cart->items->where('currency_type', 'AEC')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);


        $stripe = app(StripeWrapper::class);
        $checkoutUrl = $stripe->checkoutService()->createCheckoutSession($cart);


        return view('buyer.cart.checkout', compact('cart', 'totalUSD', 'totalAEC', 'checkoutUrl'));
    }

    public function processPayment()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();

        if (!$cart) {
            return back()->with('error', 'No items in cart.');
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

    public function create()
    {
    }

    public function stripePaymentSuccess(Request $request)
    {
        // Retrieve the cart
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();
        if (!$cart) {
            $this->discordService->sendMessage('190198403420913674', 'An order was placed but the user was not found.');

            return view('dashboard.index',
                ['message' => 'Payment successful. An admin will fill your order within 24 hours']);

        }

        $totalAEC = $cart->items->where('currency_type', 'AEC')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        // Retrieve the user
        $user = auth()->user();

        if (!$user) {
            // Notify the admin via Discord TODO change to K
            $this->discordService->sendMessage('190198403420913674', 'An order was placed but the user was not found.');

            // Return an error message to the user
            return back()->with('error', 'There was an error processing your order. Please try again.');
        }

        // Check if the user has enough AEC credits
        if ($user->ae_credits < $totalAEC) {
            return back()->with('error', 'Not enough AEG credits.');
        }

        // Deduct the total AEC from the user's AEC credits
        $user->ae_credits -= $totalAEC;

        // Update the user's AEC credits in the database
        $user->save();

        // Store the transaction in the orders table
        Order::create([
            'user_id' => auth()->id(),
            'order_contents' => $cart->items->toJson(),
        ]);

        // Remove all items from the user's cart
        $cart->items()->detach();

        //notify admin of order TODO CHANGE TO K
        $this->discordService->sendMessage('190198403420913674', 'New order has been placed. Please fill the order within 24 hours.');

        // Display a success message on an invoice page
        return view('dashboard.index',
            ['message' => 'Payment successful. AEC credits deducted successfully.  An admin will fill your order within 24 hours']);
    }

    public function stripePaymentCance(Request $request)
    {
        // Retrieve the cart
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();
        if (!$cart) {
            return back()->with('error', 'No items in cart.');
        }

        $aecItems = $cart->items->where('currency_type', 'AEC');
        $totalAEC = $aecItems->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        // Retrieve the user
        $user = auth()->user();

        // Check if the user has enough AEC credits
        if ($user->ae_credits < $totalAEC) {
            return back()->with('error', 'Not enough AEG credits.');
        }

        // Deduct the total AEC from the user's AEC credits
        $user->ae_credits -= $totalAEC;

        // Update the user's AEC credits in the database
        $user->save();

        // Store the AEC items in the orders table
        Order::create([
            'user_id' => auth()->id(),
            'items' => $aecItems->toJson(),
            'total' => $aecItems->sum('price'),
        ]);

        // Remove the AEC items from the user's cart
        $cart->items()->whereIn('id', $aecItems->pluck('id'))->detach();

        // Display a cancellation message on an invoice page
        return view('invoice', ['message' => 'Payment cancelled. AEC credits deducted successfully. An admin will fill your order within 24 hours']);
    }

    public function cancelCheckout()
    {
        return redirect()->route('dashboard.index')->with('error', 'Checkout cancelled.');
    }


}
