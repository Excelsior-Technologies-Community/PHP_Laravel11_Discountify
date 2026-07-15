<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'payment_method', 'grand_total', 'items'
    ];

    protected $casts = ['items' => 'array'];
}
