<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{
	public function index()
	{

	}

	public function create()
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

	public function destroy(Cart $cart)
	{
	}
}
