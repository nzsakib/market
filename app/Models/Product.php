<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_PENDING = 0;

    protected $fillable = ['title', 'description', 'price', 'quantity', 'status', 'user_id'];

    public function images()
    {
        return $this->hasMany(Gallery::class);
    }
}
