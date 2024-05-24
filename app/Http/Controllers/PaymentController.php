<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function processPayment()
    {
        return $this->paymentService->processPayment();
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
}
