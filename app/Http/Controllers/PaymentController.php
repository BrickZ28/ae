<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends RedirectController
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function stripePaymentSuccess(Request $request)
    {
        return $this->paymentService->stripePaymentSuccess($request);
    }

    public function stripePaymentCancel(Request $request)
    {
        return $this->paymentService->stripePaymentCancel();
    }

    public function cancelCheckout()
    {
        return $this->paymentService->cancelCheckout();
    }

    public function handleStripeResponse()
    {
        // Process the payment
        $paymentResult = $this->paymentService->handleStripeResponseService();

        // Handle the result of the payment
        return $this->handleServiceResult($paymentResult);
    }

    public function processPayment()
    {
        return $this->paymentService->processPayment();
    }
}
