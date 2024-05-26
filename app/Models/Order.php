<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function addCartItems(Cart $cart, $totalUSD)
    {
        // Filter the cart items based on their currency_type
        $cartItems = $cart->items->filter(function ($item) use ($totalUSD) {
            if ($totalUSD > 0) {
                return $item->currency_type === 'USD';
            } else {
                return $item->currency_type === 'AEC' && Auth::user()->ae_credits >= $item->price * $item->pivot->quantity;
            }
        })->toArray(); // Convert the cart items to an array

        $this->order_contents = json_encode($cartItems); // Convert the array to JSON and store it in the order_contents column
        $this->user_id = Auth::id(); // Set the user_id to the ID of the currently authenticated user

        $this->save(); // Save the order
    }

    // In your Order model

// In your Order model

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
