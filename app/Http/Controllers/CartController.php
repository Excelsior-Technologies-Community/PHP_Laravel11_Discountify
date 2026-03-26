<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
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
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'coupon' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);

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

        $cart[] = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'coupon' => $coupon,
            'coupon_discount' => $couponDiscount
        ];

        session()->put('cart', $cart);

        return redirect('/cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect('/cart');
    }
}