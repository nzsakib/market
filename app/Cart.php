<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function add(Product $product)
    {
        return $this->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }
}
