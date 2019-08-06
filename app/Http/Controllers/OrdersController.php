<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate();

        return view('customer.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = auth()->user()->orders()->findOrFail($orderId);

        return view('customer.orderDetails', compact('order'));
    }
}
