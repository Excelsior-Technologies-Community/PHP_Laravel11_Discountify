<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Safemood\Discountify\Facades\Discountify;

class CartController extends Controller
{
    // Flash sale config: global sale active until this datetime
    private function flashSale(): array
    {
        return [
            'active'      => true,
            'discount'    => 15,                          // 15% flash discount
            'ends_at'     => '2026-12-31 23:59:59',      // change as needed
            'label'       => '⚡ Flash Sale 15% OFF',
        ];
    }

    private function coupons(): array
    {
        return [
            ['code' => 'SAVE10',   'discount' => 10, 'min_purchase' => 300,  'expiry' => '2026-12-31', 'max_uses' => 50,  'status' => 1],
            ['code' => 'SAVE20',   'discount' => 20, 'min_purchase' => 1000, 'expiry' => '2026-12-31', 'max_uses' => 20,  'status' => 1],
            ['code' => 'WELCOME5', 'discount' => 5,  'min_purchase' => 100,  'expiry' => '2026-12-31', 'max_uses' => 100, 'status' => 1],
        ];
    }

    // Tiered discount: highest applicable tier wins
    private function getTieredDiscount(array $items): array
    {
        $totalQty   = collect($items)->sum(fn($i) => $i['quantity']);
        $totalValue = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        // Quantity tiers
        if ($totalQty >= 5)       return ['pct' => 12, 'label' => 'Buy 5+ items: 12% OFF'];
        if ($totalQty >= 3)       return ['pct' => 5,  'label' => 'Buy 3+ items: 5% OFF'];

        // Value tiers
        if ($totalValue > 2000)   return ['pct' => 30, 'label' => 'Cart > ₹2000: 30% OFF'];
        if ($totalValue > 1000)   return ['pct' => 20, 'label' => 'Cart > ₹1000: 20% OFF'];
        if ($totalValue > 500)    return ['pct' => 10, 'label' => 'Cart > ₹500: 10% OFF'];

        return ['pct' => 0, 'label' => ''];
    }

    private function getCouponUsage(string $code): int
    {
        return Product::where('coupon', $code)->count();
    }

    public function index()
    {
        $cart         = Product::latest()->paginate(5);
        $allProducts  = Product::all();
        $totalProducts = $allProducts->count();
        $totalValue   = $allProducts->sum(fn($p) => $p->price * $p->quantity);
        $totalSaved   = $allProducts->sum(fn($p) => ($p->price * $p->quantity * $p->coupon_discount) / 100);
        $mostUsedCoupon = 'None';
        $couponUsage  = [];

        foreach ($allProducts as $item) {
            if ($item->coupon) {
                $couponUsage[$item->coupon] = ($couponUsage[$item->coupon] ?? 0) + 1;
            }
        }
        if (!empty($couponUsage)) {
            $mostUsedCoupon = array_keys($couponUsage, max($couponUsage))[0];
        }

        $flashSale   = $this->flashSale();
        $flashActive = $flashSale['active'] && Carbon::now()->lt(Carbon::parse($flashSale['ends_at']));
        $tiered      = $this->getTieredDiscount($allProducts->toArray());
        $cartCount   = $totalProducts;

        return view('cart', compact(
            'cart', 'totalProducts', 'totalValue', 'totalSaved',
            'mostUsedCoupon', 'flashSale', 'flashActive', 'tiered', 'cartCount'
        ));
    }

    public function create()
    {
        $availableCoupons = $this->coupons();
        $flashSale        = $this->flashSale();
        $flashActive      = $flashSale['active'] && Carbon::now()->lt(Carbon::parse($flashSale['ends_at']));
        $cartCount        = Product::count();

        return view('create-product', compact('availableCoupons', 'flashSale', 'flashActive', 'cartCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'coupon'   => 'nullable|string',
        ]);

        $couponInput   = strtoupper($request->coupon ?? '');
        $matchedCoupon = null;

        foreach ($this->coupons() as $c) {
            if ($c['code'] === $couponInput) {
                $matchedCoupon = $c;
                break;
            }
        }

        $productTotal  = $request->price * $request->quantity;
        $couponDiscount = 0;

        if ($matchedCoupon) {
            if (!$matchedCoupon['status']) {
                return back()->with('error', 'Coupon is inactive.');
            }
            if (Carbon::now()->gt(Carbon::parse($matchedCoupon['expiry']))) {
                return back()->with('error', 'Coupon has expired.');
            }
            if ($productTotal < $matchedCoupon['min_purchase']) {
                return back()->with('error', 'Minimum purchase ₹' . $matchedCoupon['min_purchase'] . ' required.');
            }
            if ($this->getCouponUsage($couponInput) >= $matchedCoupon['max_uses']) {
                return back()->with('error', 'Coupon usage limit reached.');
            }
            $couponDiscount = $matchedCoupon['discount'];
        }

        // Flash sale discount
        $flashSale    = $this->flashSale();
        $flashActive  = $flashSale['active'] && Carbon::now()->lt(Carbon::parse($flashSale['ends_at']));
        $flashDiscount = $flashActive ? $flashSale['discount'] : 0;
        $flashEndsAt  = $flashActive ? Carbon::parse($flashSale['ends_at']) : null;

        Product::create([
            'name'             => $request->name,
            'price'            => $request->price,
            'quantity'         => $request->quantity,
            'coupon'           => $couponDiscount ? $couponInput : null,
            'coupon_discount'  => $couponDiscount,
            'flash_discount'   => $flashDiscount,
            'flash_sale_ends_at' => $flashEndsAt,
        ]);

        return redirect('/cart')->with('success', 'Product added!');
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        Product::findOrFail($id)->update(['quantity' => $request->quantity]);
        return redirect('/cart')->with('success', 'Quantity updated!');
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return redirect('/cart')->with('success', 'Item removed!');
    }

    public function edit($id)
    {
        $product          = Product::findOrFail($id);
        $availableCoupons = $this->coupons();
        $cartCount        = Product::count();
        return view('edit-product', compact('product', 'availableCoupons', 'cartCount'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $coupon  = strtoupper($request->coupon ?? '');
        $discount = 0;

        foreach ($this->coupons() as $c) {
            if ($c['code'] === $coupon) {
                $discount = $c['discount'];
                break;
            }
        }

        $product->update([
            'name'            => $request->name,
            'price'           => $request->price,
            'quantity'        => $request->quantity,
            'coupon'          => $discount ? $coupon : null,
            'coupon_discount' => $discount,
        ]);

        return redirect('/cart')->with('success', 'Product updated!');
    }

    public function clear()
    {
        Product::truncate();
        return redirect('/cart');
    }

    public function checkout()
    {
        $allProducts = Product::all();
        if ($allProducts->isEmpty()) {
            return redirect('/cart')->with('error', 'Cart is empty!');
        }

        $tiered      = $this->getTieredDiscount($allProducts->toArray());
        $flashSale   = $this->flashSale();
        $flashActive = $flashSale['active'] && Carbon::now()->lt(Carbon::parse($flashSale['ends_at']));
        $cartCount   = $allProducts->count();

        $items = $allProducts->map(function ($item) use ($tiered, $flashActive, $flashSale) {
            $subtotal      = $item->price * $item->quantity;
            $couponAmt     = ($subtotal * $item->coupon_discount) / 100;
            $flashAmt      = $flashActive ? ($subtotal * $flashSale['discount']) / 100 : 0;
            $tieredAmt     = ($subtotal * $tiered['pct']) / 100;
            $totalDiscount = $couponAmt + $flashAmt + $tieredAmt;
            $tax           = (($subtotal - $totalDiscount) * 18) / 100;
            $final         = $subtotal - $totalDiscount + $tax;

            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'price'         => $item->price,
                'quantity'      => $item->quantity,
                'subtotal'      => $subtotal,
                'coupon'        => $item->coupon,
                'coupon_pct'    => $item->coupon_discount,
                'flash_pct'     => $flashActive ? $flashSale['discount'] : 0,
                'tiered_pct'    => $tiered['pct'],
                'total_discount'=> $totalDiscount,
                'tax'           => $tax,
                'final'         => $final,
            ];
        });

        $grandTotal = $items->sum('final');

        return view('checkout', compact('items', 'grandTotal', 'tiered', 'flashActive', 'flashSale', 'cartCount'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'           => 'required|string',
            'email'          => 'required|email',
            'phone'          => 'required|digits_between:10,12',
            'address'        => 'required|string',
            'payment_method' => 'required|in:cod,upi,card',
        ]);

        $allProducts = Product::all();
        $tiered      = $this->getTieredDiscount($allProducts->toArray());
        $flashSale   = $this->flashSale();
        $flashActive = $flashSale['active'] && Carbon::now()->lt(Carbon::parse($flashSale['ends_at']));

        $items = $allProducts->map(function ($item) use ($tiered, $flashActive, $flashSale) {
            $subtotal      = $item->price * $item->quantity;
            $couponAmt     = ($subtotal * $item->coupon_discount) / 100;
            $flashAmt      = $flashActive ? ($subtotal * $flashSale['discount']) / 100 : 0;
            $tieredAmt     = ($subtotal * $tiered['pct']) / 100;
            $totalDiscount = $couponAmt + $flashAmt + $tieredAmt;
            $tax           = (($subtotal - $totalDiscount) * 18) / 100;
            return array_merge($item->toArray(), ['final' => $subtotal - $totalDiscount + $tax]);
        })->toArray();

        $grandTotal = collect($items)->sum('final');

        $order = Order::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'payment_method' => $request->payment_method,
            'grand_total'    => $grandTotal,
            'items'          => $items,
        ]);

        Product::truncate();

        return redirect('/order-success/' . $order->id);
    }

    public function orderSuccess($id)
    {
        $order     = Order::findOrFail($id);
        $cartCount = 0;
        return view('order-success', compact('order', 'cartCount'));
    }
}
