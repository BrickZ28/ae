<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
//TODO: need to add status, ie started, completed, cancelled etc
    public function index()
    {
        $orders = Order::with('user')->get();
        $filters = ['id', 'User', 'status', 'processed by', 'date created', 'date completed', ' actions'];

        return view('dashboard.order.index', compact('orders', 'filters'));
    }

    public function show(Order $order)
    {
        $orderContents = json_decode($order->order_contents, true);
        $orderContents['items'] = array_values($orderContents['items']);

        $usdItems = array_filter($orderContents['items'], function ($item) {
            return $item['currency_type'] === 'USD';
        });
        $aecItems = array_filter($orderContents['items'], function ($item) {
            return $item['currency_type'] === 'AEC';
        });

        $usdSubtotal = 0;
        $aecSubtotal = 0;

        foreach ($orderContents['items'] as $item) {
            $totalPrice = $item['price'] * $item['pivot']['quantity'];

            if ($item['currency_type'] === 'USD') {
                $usdSubtotal += $totalPrice;
            } else {
                $aecSubtotal += $totalPrice;
            }
        }

        return view('dashboard.order.show', compact('order', 'orderContents', 'usdItems', 'aecItems', 'usdSubtotal', 'aecSubtotal'));
    }
}
