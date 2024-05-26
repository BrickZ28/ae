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
		return view('dashboard.order.show', compact('order'));
	}
}
