<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
   public function index()
{
    $cart = Product::latest()->get();
    return view('cart', compact('cart'));
}

    public function create()
    {
        $availableCoupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME5' => 5
        ];

        return view('create-product', compact('availableCoupons'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer'
    ]);

    $availableCoupons = [
        'SAVE10' => 10,
        'SAVE20' => 20,
        'WELCOME5' => 5
    ];

    $coupon = strtoupper($request->coupon ?? '');
    $couponDiscount = $availableCoupons[$coupon] ?? 0;

    if ($couponDiscount === 0) {
        $coupon = null;
    }

    // ✅ SAVE TO DATABASE
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'coupon' => $coupon,
        'coupon_discount' => $couponDiscount
    ]);

    return redirect('/cart');
}

    public function clear()
    {
        session()->forget('cart');
        return redirect('/cart');
    }

   public function delete($id)
{
    Product::findOrFail($id)->delete();
    return redirect('/cart');
}

public function edit($id)
{
    $product = Product::findOrFail($id);

    $availableCoupons = [
        'SAVE10' => 10,
        'SAVE20' => 20,
        'WELCOME5' => 5
    ];

    return view('edit-product', compact('product', 'availableCoupons'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $availableCoupons = [
        'SAVE10' => 10,
        'SAVE20' => 20,
        'WELCOME5' => 5
    ];

    $coupon = strtoupper($request->coupon ?? '');
    $couponDiscount = $availableCoupons[$coupon] ?? 0;

    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'coupon' => $couponDiscount ? $coupon : null,
        'coupon_discount' => $couponDiscount
    ]);

    return redirect('/cart');
}
}