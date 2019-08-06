<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\OrderRepository;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\Customer\OrderDetailsResource;

class OrdersController extends Controller
{
    private $orderRepo;

    public function __Construct(OrderRepository $order)
    {
        $this->middleware('auth');
        $this->orderRepo = $order;
    }

    public function index()
    {
        return view('customer.orders');
    }

    public function show($orderId)
    {
        return view('customer.orderDetails', compact('orderId'));
    }
}
