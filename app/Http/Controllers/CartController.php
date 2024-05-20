<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\CartService;
use App\Services\DiscordService;
use Illuminate\Http\Request;

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
        return $this->handleServiceResult($this->cartService->updateCartQuantityService($id, $request));
    }

    public function checkout()
    {
        return $this->cartService->cartCheckoutService();
    }


    public function create()
    {
    }


}
