<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrdersResource;

class OrdersController extends Controller
{
    public function __Construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->paginate(1);

        if (request()->wantsJson()) {
            return OrdersResource::collection($orders);
        }

        return view('customer.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = auth()->user()->orders()->findOrFail($orderId);

        return view('customer.orderDetails', compact('order'));
    }
}
