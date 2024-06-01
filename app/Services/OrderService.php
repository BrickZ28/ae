<?php

namespace App\Services;


use App\Models\CancelledItems;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class OrderService
{

    public function orderIndexService()
    {
        $orders = Order::with('user')->get();
        $filters = ['id', 'User', 'status', 'processed by', 'date created', 'date completed', ' actions'];

        return view('dashboard.order.index', compact('orders', 'filters'));
    }

    public function orderShowService(Order $order)
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

    public function orderEditService($order)
    {
        $statuses = Status::all();
        $orderContents = json_decode($order->order_contents, true);
        foreach ($orderContents['items'] as &$item) {
            $item['complete'] = isset($item['complete']) ? $item['complete'] : false; // Provide a default value if the 'complete' key does not exist
        }
        unset($item); // Unset the reference to prevent side-effects
        $orderItems = $orderContents['items'];
        return view('dashboard.order.edit', compact('order', 'statuses', 'orderItems'));
    }

    public function orderUpdateService($request, $order)
    {
        $order->status_id = $request->status;
        $order->save();

        $itemStatuses = request('itemStatus');
        $orderContents = json_decode($order->order_contents, true);
        foreach ($orderContents['items'] as &$item) {
            $item['complete'] = isset($itemStatuses[$item['id']]);
        }
        unset($item); // Unset the reference to prevent side-effects
        $order->order_contents = json_encode($orderContents);
        $order->save();

        //TODO check if completed

        return redirect()->route('orders.show', $order)->withSuccess('Order status updated successfully');
    }

    public function cancelAECOrderService($order)
    {
        $orderContents = json_decode($order->order_contents, true);
        $orderContents['items'] = array_values($orderContents['items']);

        foreach ($orderContents['items'] as $item) {
            $totalPrice = $item['price'] * $item['pivot']['quantity'];
            if ($item['currency_type'] === 'AEC') {
                CancelledItems::insert([
                    'order_id' => $order->id,
                    'item_id' => $item['id'],
                    'user_id' => $order->user_id,
                    'quantity' => $item['pivot']['quantity'],
                ]);
            }
            $totalPrice += $totalPrice;
        }

        // Remove the AEC items from the order contents
        $orderContents['items'] = array_filter($orderContents['items'], function ($item) {
            return $item['currency_type'] !== 'AEC';
        });

        //refund the aec
        Auth::user()->ae_credits += $totalPrice;
        Auth::user()->save();

        // Re-index the array and update the order contents
        $order->order_contents = json_encode(['items' => array_values($orderContents['items'])]);
        $order->save();

        return redirect(route('dashboard.index', $order))->withSuccess('AE Credits refunded successfully');
    }

}
