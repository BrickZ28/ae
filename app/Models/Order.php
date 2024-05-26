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
                // No need to check for credits here, as it's already been done in the PaymentService
                return $item->currency_type === 'AEC';
            }
        })->toArray(); // Convert the cart items to an array

        $this->order_contents = json_encode($cartItems); // Convert the array to JSON and store it in the order_contents column
        $this->user_id = Auth::id(); // Set the user_id to the ID of the currently authenticated user

        $this->save(); // Save the order
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
