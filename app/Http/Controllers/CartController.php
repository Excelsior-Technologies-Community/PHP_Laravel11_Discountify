<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    private function coupons()
    {
        return [
            [
                'code' => 'SAVE10',
                'discount' => 10,
                'min_purchase' => 300,
                'expiry' => '2026-12-31',
                'status' => 1
            ],
            [
                'code' => 'SAVE20',
                'discount' => 20,
                'min_purchase' => 1000,
                'expiry' => '2026-12-31',
                'status' => 1
            ],
            [
                'code' => 'WELCOME5',
                'discount' => 5,
                'min_purchase' => 100,
                'expiry' => '2026-12-31',
                'status' => 1
            ]
        ];
    }

    public function index()
    {
        $cart = Product::latest()->paginate(3);

        $totalProducts = Product::count();

        $totalValue = Product::sum(\DB::raw('price * quantity'));

        $totalSaved = 0;

        $couponUsage = [];

        foreach (Product::all() as $item) {

            $total = $item->price * $item->quantity;

            $discount = ($total * $item->coupon_discount) / 100;

            $totalSaved += $discount;

            if ($item->coupon) {

                if (!isset($couponUsage[$item->coupon])) {
                    $couponUsage[$item->coupon] = 0;
                }

                $couponUsage[$item->coupon]++;
            }
        }

        $mostUsedCoupon =
            !empty($couponUsage)
            ? array_keys($couponUsage, max($couponUsage))[0]
            : 'None';

        return view(
            'cart',
            compact(
                'cart',
                'totalProducts',
                'totalValue',
                'totalSaved',
                'mostUsedCoupon'
            )
        );
    }

    public function create()
    {
        $availableCoupons = $this->coupons();

        return view('create-product', compact('availableCoupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'coupon' => 'nullable'
        ]);

        $couponInput = strtoupper($request->coupon ?? '');

        $matchedCoupon = null;

        foreach ($this->coupons() as $coupon) {
            if ($coupon['code'] == $couponInput) {
                $matchedCoupon = $coupon;
                break;
            }
        }

        $couponDiscount = 0;

        $productTotal =
            $request->price * $request->quantity;

        if ($matchedCoupon) {

            if (!$matchedCoupon['status']) {
                return back()->with(
                    'error',
                    'Coupon inactive'
                );
            }

            if (
                Carbon::now()->gt(
                    Carbon::parse(
                        $matchedCoupon['expiry']
                    )
                )
            ) {
                return back()->with(
                    'error',
                    'Coupon expired'
                );
            }

            if (
                $productTotal <
                $matchedCoupon['min_purchase']
            ) {
                return back()->with(
                    'error',
                    'Minimum purchase should be ₹' .
                        $matchedCoupon['min_purchase']
                );
            }

            $couponDiscount =
                $matchedCoupon['discount'];
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'coupon' => $couponDiscount ? $couponInput : null,
            'coupon_discount' => $couponDiscount
        ]);

        return redirect('/cart')
            ->with(
                'success',
                'Product added successfully'
            );
    }

    public function clear()
    {
        Product::truncate();

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

        $availableCoupons = $this->coupons();

        return view(
            'edit-product',
            compact(
                'product',
                'availableCoupons'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $coupon = strtoupper($request->coupon ?? '');

        $discount = 0;

        foreach ($this->coupons() as $c) {
            if ($c['code'] == $coupon) {
                $discount = $c['discount'];
                break;
            }
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'coupon' => $discount ? $coupon : null,
            'coupon_discount' => $discount
        ]);

        return redirect('/cart');
    }
}
