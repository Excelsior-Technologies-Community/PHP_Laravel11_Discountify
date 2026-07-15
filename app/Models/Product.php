<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'quantity', 'coupon',
        'coupon_discount', 'flash_discount', 'flash_sale_ends_at'
    ];

    protected $casts = ['flash_sale_ends_at' => 'datetime'];
}
