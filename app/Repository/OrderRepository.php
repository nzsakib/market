<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
    public function getOrderPaginate(User $user, int $perPage) : LengthAwarePaginator
    {
        return $user->orders()->paginate($perPage);
    }

    public function orderDetailsOfUser(User $user, int $orderId) : Order
    {
        return $user->orders()->with('orderItems.product')->findOrFail($orderId);
    }
}
