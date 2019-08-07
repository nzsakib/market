<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['title', 'description', 'price', 'quantity', 'status', 'user_id'];

    public function images()
    {
        return $this->hasMany(Gallery::class);
    }
}
