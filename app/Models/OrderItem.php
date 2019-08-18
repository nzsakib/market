<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = ['product_id', 'price', 'order_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopePending($query)
    {
        return $query->whereHas('order', function ($q) {
            $q->where('status', 'pending');
        });
    }
}
