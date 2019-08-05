<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['name', 'phone', 'address', 'total'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
