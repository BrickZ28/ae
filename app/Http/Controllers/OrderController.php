<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function index()
    {
        return $this->orderService->orderIndexService();
    }

    public function show(Order $order)
    {
        return $this->orderService->orderShowService($order);
    }

    public function edit(Order $order)
    {
        return $this->orderService->orderEditService($order);
    }

    public function update(Request $request, Order $order)
    {
        return $this->orderService->orderUpdateService($request, $order);
    }

    public function cancelAECOrder($order)
    {

        return $this->orderService->cancelAECOrderService(Order::find($order));
    }

    public function orderInquiry($id)
    {
        $this->orderService->orderInquireService(Order::find($id));

        return redirect()->route('dashboard.index')->with('success', 'Inquiry Sent');
    }


}
