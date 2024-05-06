<?php

namespace App\Services\Stripe\Product;

use App\Models\Item;
use App\Services\Stripe\StripeWrapper;

class StripeProductService
{
    private $stripeWrapper;

    public function __construct(StripeWrapper $stripeWrapper)
    {
        $this->stripeWrapper = $stripeWrapper;
    }

    public function syncStripeProductsToDatabase()
    {
        $items = Item::where('currency_type', 'USD')->get();
        $results = [];

        foreach ($items as $item) {
            $params = [
                'active' => (bool)$item->active,
                'name' => $item->name,
                'description' => $item->description,
                'metadata' => [
                    'category_id' => $item->category->name,
                    'game_id' => $item->game->display_name,
                    'playstyle_id' => $item->playstyle->name,
                ],
            ];

            if (!empty($item->image)) {
                $params['images'] = $item->image;
            }

            // Check if the product exists on Stripe

            $products = $this->stripeWrapper->listProducts(['active' => true]);
            $existingProduct = null;

            foreach ($products->data as $product) {
                if ($product->name == $item->name) {
                    $existingProduct = $product;
                    break;
                }
            }

            if ($existingProduct) {
                // Compare the data between the database and Stripe
                if ($existingProduct->description != $item->description || $existingProduct->active != (bool)$item->active) {
                    // If the data is different, update the product on Stripe
                    $existingProduct->description = $item->description;
                    $existingProduct->active = (bool)$item->active;
                    $existingProduct->save();
                }

                $product = $existingProduct;
            } else {
                // If the product does not exist, create a new one
                $product = $this->stripeWrapper->createProduct($params);
            }

            // Create a price and associate it with the product
            $priceParams = [
                'unit_amount' => $item->price * 100, // convert to cents
                'currency' => 'usd',
                'product' => $product->id,
            ];

            $price = $this->stripeWrapper->createPrice($priceParams);

            $results[] = ['product' => $product, 'price' => $price];
        }

        return redirect()->route('items.index')->with('success', 'Items uploaded to Stripe successfully');
    }
}
