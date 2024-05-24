<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\CartService;
use App\Services\DiscordService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CartController extends RedirectController
{

    private $cartService;
    private $paymentService;

    public function __construct(PaymentService $paymentservice, CartService $cartService)
    {

        $this->cartService = $cartService;
        $this->paymentService = $paymentservice;
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
        $checkoutData = $this->cartService->cartCheckoutService();

        return $this->paymentService->processPayment($checkoutData['cart'], $checkoutData['totalUSD'], $checkoutData['totalAEC']);
    }


    public function create()
    {
    }


}
