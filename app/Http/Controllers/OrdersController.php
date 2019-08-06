<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\Customer\OrderDetailsResource;

class OrdersController extends Controller
{
    private $orderRepo;

    public function __Construct()
    {
        $this->middleware('auth');
        // $this->orderRepo = $order;
    }

    public function index()
    {
        $orders = auth()->user()->orders()->paginate(10);
        // $this->orderRepo->getOrdersPaginate($user, 15);

        if (request()->wantsJson()) {
            return OrdersResource::collection($orders);
        }

        return view('customer.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = auth()->user()->orders()->with('orderItems.product')->findOrFail($orderId);

        if (request()->wantsJson()) {
            OrderDetailsResource::withoutWrapping();
            return new OrderDetailsResource($order);
        }

        return view('customer.orderDetails', compact('order'));
    }
}
