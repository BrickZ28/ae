<?php

namespace App\Services;


use App\Models\Cart;
use App\Models\Item;
use App\Services\Stripe\StripeWrapper;

class CartService
{

    public function cartServiceStore($request)
    {
        $item = Item::find($request->input('id')); // Get the item from the request data

        if (!$item) {
            return ['status' => 'error', 'message' => 'Item not found'];
        }

        $quantity = $request->input('quantity'); // Get the quantity from the request data

        $cart = $this->getUsersCart(); // Get the cart of the user
        $cart->items()->attach($item->id, ['quantity' => $quantity]);

        return ['status' => 'success', 'message' => 'Item added to cart successfully', 'redirectTo' => 'dashboard'];
    }

    private function getUsersCart(array $relations = [])
    {
        $cart = Cart::where('user_id', auth()->id())->with($relations)->first();
        if (!$cart) {
            return back()->with('error', 'No items in cart.');
        }
        return $cart;
    }

    public function cartServiceShow()
    {
        $cart = $this->getUsersCart(['items']);

        $itemsUSD = $cart->items->where('currency_type', 'USD');
        $totalUSD = $this->calculateTotal($itemsUSD);

        $itemsAEC = $cart->items->where('currency_type', 'AEC');
        $totalAEC = $this->calculateTotal($itemsAEC);

        return view('buyer.cart.show', compact('itemsUSD', 'totalUSD', 'itemsAEC', 'totalAEC'));
    }

    private function calculateTotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->pivot->quantity;
        }
        return $total;
    }

    public function cartDestroyService($id)
    {
        $cart = $this->getUsersCart();

        // Retrieve the item
        $item = Item::find($id);

        // Check if the item exists
        if (!$item) {
            return ['status' => 'error', 'message' => 'Item not found', 'redirectTo' => 'dashboard'];
        }

        // Detach the item from the cart
        $cart->items()->detach($item->id);

        // Check if the cart is empty
        if ($cart->items->isEmpty()) {
            // Delete the cart if it's empty
            $cart->delete();
        }

        if (!Cart::where('user_id', auth()->id())->first()) {
            return ['status' => 'success', 'message' => 'Item removed from cart. Cart is now empty', 'redirectTo' => 'dashboard'];
        }

        return ['status' => 'success', 'message' => 'Item removed from cart', 'redirectTo' => 'back'];
    }

    public function updateCartQuantityService($id, $request)
    {
        // Retrieve the cart
        $cart = Cart::where('user_id', auth()->id())->first();

        // Check if the cart exists
        if (!$cart) {
            return ['status' => 'error', 'message' => 'No cart found', 'redirectTo' => 'back'];
        }

        // Retrieve the item
        $item = Item::find($id);

        // Check if the item exists
        if (!$item) {
            return ['status' => 'error', 'message' => 'No item found', 'redirectTo' => 'back'];
        }

        // Update the quantity of the item in the cart
        $cart->items()->updateExistingPivot($item->id, ['quantity' => $request->quantity]);

        return ['status' => 'success', 'message' => 'Quantity updated', 'redirectTo' => 'back'];
    }

    public function cartCheckoutService()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items')->first();

        if (!$cart) {
            return ['status' => 'error', 'message' => 'No cart found', 'redirectTo' => 'back'];
        }

        $totalUSD = $cart->items->where('currency_type', 'USD')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);

        $totalAEC = $cart->items->where('currency_type', 'AEC')->reduce(function ($carry, $item) {
            return $carry + ($item->price * $item->pivot->quantity);
        }, 0);


        return [
            'cart' => $cart,
            'totalUSD' => $totalUSD,
            'totalAEC' => $totalAEC,
        ];
    }

}
