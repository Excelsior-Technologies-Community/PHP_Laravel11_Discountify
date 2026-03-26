<?php

namespace App\Http\Controllers;

use Safemood\Discountify\Facades\Discountify;

class DiscountController extends Controller
{
    public function index()
{
    $items = [
        ['price' => 100, 'quantity' => 2],
        ['price' => 200, 'quantity' => 1],
        ['price' => 150, 'quantity' => 1],
    ];

    // ✅ Manual total (ORIGINAL)
    $total = collect($items)->sum(function ($item) {
        return $item['price'] * $item['quantity'];
    });

    $discount = \Safemood\Discountify\Facades\Discountify::setItems($items)
        ->setGlobalDiscount(5);

    $discounted = $discount->totalWithDiscount();

    // ✅ Manual tax
    $tax = ($discounted * 18) / 100;

    return response()->json([
        'total' => $total, // 550 ✅
        'discounted_total' => $discounted,
        'tax' => $tax,
        'final_total' => $discounted + $tax,
    ]);
}
}