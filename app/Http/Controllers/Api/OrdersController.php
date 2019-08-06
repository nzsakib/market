<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repository\OrderRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\Customer\OrderDetailsResource;

class OrdersController extends Controller
{
    private $orderRepo;

    public function __construct(OrderRepository $order)
    {
        $this->middleware('auth');
        $this->orderRepo = $order;
    }

    public function index()
    {
        $orders = $this->orderRepo->getOrderPaginate(auth()->user(), 15);

        return OrdersResource::collection($orders);
    }

    public function show($orderId)
    {
        $order = $this->orderRepo->orderDetailsOfUser(auth()->user(), $orderId);

        OrderDetailsResource::withoutWrapping();
        return new OrderDetailsResource($order);
    }
}
