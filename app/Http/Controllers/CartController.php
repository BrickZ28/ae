<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Services\Stripe\StripeWrapper;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {

        $item = Item::find($request->input('id')); // Get the item from the request data
        // This will display the items in the cart (for testing purposes only

        $quantity = $request->input('quantity'); // Get the quantity from the request data

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->items()->attach($item->id, ['quantity' => $quantity]);


        return back()->with('success', 'Item added to cart successfully.');
    }

    public function show()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();

        if (!$cart) {
            return back()->with('error', 'No items in cart.');
        }

        $itemsUSD = $cart->items->where('currency_type', 'USD');
        $totalUSD = $itemsUSD->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        $itemsAEC = $cart->items->where('currency_type', 'AEC');
        $totalAEC = $itemsAEC->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        return view('buyer.cart.show', compact('itemsUSD', 'totalUSD', 'itemsAEC', 'totalAEC'));
    }

    public function edit(Cart $cart)
    {
    }

    public function update(Request $request, Cart $cart)
    {
    }

    public function destroy($id)
    {
        // Retrieve the cart
        $cart = Cart::where('user_id', auth()->id())->first();

        // Check if the cart exists
        if (!$cart) {
            return redirect()->route('dashboard.index')->with('error', 'No Cart found.');
        }

        // Retrieve the item
        $item = Item::find($id);

        // Check if the item exists
        if (!$item) {
            return redirect()->route('dashboard.index')->with('error', 'No Item found.');
        }

        // Detach the item from the cart
        $cart->items()->detach($item->id);

        // Check if the cart is empty
        if ($cart->items->isEmpty()) {
            // Delete the cart if it's empty
            $cart->delete();
        }

        if (!Cart::where('user_id', auth()->id())->first()) {
            return redirect()->route('dashboard.index')->with('success', 'Item removed from cart and cart is empty.');
        } else {
            return back()->with('success', 'Item removed from cart successfully.');
        }
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
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

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
                'success_url' => url('/success'), //TODO
                'cancel_url' => url('/cancel'), //TODO
            ]);

            return redirect($checkout_session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function create()
    {
    }

    public function cancelCheckout()
    {
        return redirect()->route('dashboard.index')->with('error', 'Checkout cancelled.');
    }


}
