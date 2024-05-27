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

    public function addCartItems(Cart $cart, $totalUSD, $totalAEC)
    {
        // Filter the cart items based on their currency_type
        $cartItems = $cart->items->filter(function ($item) {
            return $item->currency_type === 'USD' || $item->currency_type === 'AEC';
        })->values()->toArray(); // Reset the keys and convert the cart items to an array

        // Prepare the order contents
        $orderContents = [
            'items' => $cartItems,
            'totalUSD' => $totalUSD,
            'totalAEC' => $totalAEC,
        ];

        $this->order_contents = json_encode($orderContents); // Convert the array to JSON and store it in the order_contents column
        $this->user_id = Auth::id(); // Set the user_id to the ID of the currently authenticated user

        $this->save(); // Save the order
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
