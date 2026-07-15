<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Discountify Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{background:linear-gradient(135deg,#0f172a,#1e293b,#334155);min-height:100vh;padding:30px;color:white}
        .container{max-width:1350px;margin:auto}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:20px}
        .heading h1{font-size:34px;font-weight:700}
        .heading p{opacity:.7;margin-top:5px}
        .buttons{display:flex;gap:12px;align-items:center}
        .btn{padding:12px 20px;border-radius:12px;text-decoration:none;font-weight:600;color:white;background:linear-gradient(90deg,#06b6d4,#3b82f6);transition:.3s;box-shadow:0 6px 20px rgba(59,130,246,.3)}
        .btn:hover{transform:translateY(-4px)}
        .btn-danger{background:linear-gradient(90deg,#ef4444,#dc2626)}
        .btn-green{background:linear-gradient(90deg,#10b981,#059669)}

        /* Cart Badge */
        .cart-badge-wrap{position:relative;display:inline-block}
        .cart-badge{position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;border-radius:50%;width:22px;height:22px;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center}

        /* Flash Sale Banner */
        .flash-banner{background:linear-gradient(90deg,#f59e0b,#ef4444);padding:14px 20px;border-radius:16px;margin-bottom:25px;display:flex;justify-content:space-between;align-items:center;font-weight:600;font-size:15px;box-shadow:0 6px 20px rgba(239,68,68,.4)}
        .flash-timer{font-size:13px;opacity:.9}

        /* Tiered Discount Banner */
        .tier-banner{background:linear-gradient(90deg,#7c3aed,#4f46e5);padding:12px 20px;border-radius:14px;margin-bottom:20px;font-size:14px;font-weight:600;box-shadow:0 4px 15px rgba(124,58,237,.4)}

        .analytics{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px}
        .card{background:rgba(255,255,255,.08);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.08);padding:25px;border-radius:22px;box-shadow:0 8px 30px rgba(0,0,0,.25);transition:.3s}
        .card:hover{transform:translateY(-6px)}
        .card h4{opacity:.7;font-size:14px;margin-bottom:10px}
        .card h2{font-size:28px;font-weight:700}
        .search{position:relative;margin-bottom:25px}
        .search input{width:100%;padding:16px 20px 16px 50px;border:none;outline:none;background:rgba(255,255,255,.08);border-radius:14px;color:white;font-size:15px}
        .search span{position:absolute;left:18px;top:16px;opacity:.6}
        .table-box{background:rgba(255,255,255,.08);backdrop-filter:blur(16px);padding:20px;border-radius:25px;overflow:auto;box-shadow:0 8px 30px rgba(0,0,0,.25)}
        table{width:100%;border-collapse:collapse}
        th{padding:16px;font-size:13px;background:rgba(255,255,255,.06)}
        td{padding:14px;text-align:center;border-bottom:1px solid rgba(255,255,255,.06);font-size:13px}
        tr:hover{background:rgba(255,255,255,.03)}
        .badge{display:inline-block;padding:6px 12px;border-radius:30px;background:#10b981;font-size:11px;font-weight:600}
        .badge-flash{background:linear-gradient(90deg,#f59e0b,#ef4444)}
        .badge-tier{background:linear-gradient(90deg,#7c3aed,#4f46e5)}
        .discount{color:#22c55e;font-weight:700}

        /* Inline qty form */
        .qty-form{display:flex;align-items:center;gap:6px;justify-content:center}
        .qty-input{width:60px;padding:6px;border-radius:8px;border:1px solid rgba(255,255,255,.2);background:#1e293b;color:white;text-align:center;font-size:13px}
        .qty-btn{padding:6px 10px;border:none;border-radius:8px;background:#06b6d4;color:white;cursor:pointer;font-size:12px;font-weight:600;transition:.2s}
        .qty-btn:hover{background:#0891b2}

        .action-btns{display:flex;gap:6px;justify-content:center;flex-wrap:wrap}
        .edit{padding:7px 12px;background:#3b82f6;color:white;text-decoration:none;border-radius:10px;font-size:12px}
        .delete{padding:7px 12px;background:#ef4444;color:white;text-decoration:none;border-radius:10px;font-size:12px}

        .total-box{margin-top:25px;background:linear-gradient(90deg,#06b6d4,#2563eb);padding:25px;border-radius:22px;font-size:24px;font-weight:700;display:flex;justify-content:space-between;align-items:center;box-shadow:0 8px 30px rgba(59,130,246,.4)}
        .checkout-btn{padding:14px 28px;background:white;color:#1e293b;border-radius:14px;text-decoration:none;font-weight:700;font-size:15px;transition:.3s}
        .checkout-btn:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,.3)}

        .success{padding:15px;margin-bottom:20px;background:#22c55e;border-radius:12px;font-weight:600}
        .error-msg{padding:15px;margin-bottom:20px;background:#ef4444;border-radius:12px;font-weight:600}

        .pagination-box{display:flex;justify-content:center;margin-top:35px;margin-bottom:20px}
        .custom-pagination{display:flex;align-items:center;gap:14px;list-style:none;padding:0;margin:0}
        .custom-pagination li a,.custom-pagination li span{width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:14px;text-decoration:none;font-weight:700;font-size:16px;color:white;background:rgba(255,255,255,.08);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08);box-shadow:0 5px 20px rgba(0,0,0,.25);transition:.3s}
        .custom-pagination li a:hover{transform:translateY(-4px);background:linear-gradient(90deg,#06b6d4,#3b82f6)}
        .custom-pagination .active span{background:linear-gradient(90deg,#06b6d4,#3b82f6)}
        .custom-pagination .disabled{width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:14px;opacity:.4;background:rgba(255,255,255,.05)}

        @media(max-width:768px){.header{flex-direction:column;align-items:flex-start}.buttons{width:100%}.btn{flex:1;text-align:center}}
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="heading">
            <h1>🛒 Discountify Dashboard</h1>
            <p>Smart Coupon & Cart Analytics System</p>
        </div>
        <div class="buttons">
            <div class="cart-badge-wrap">
                <a href="/create-product" class="btn">+ Add Product</a>
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </div>
            <a href="/clear-cart" class="btn btn-danger">🗑 Clear Cart</a>
        </div>
    </div>

    {{-- Flash Sale Banner --}}
    @if($flashActive)
    <div class="flash-banner">
        <span>{{ $flashSale['label'] }} — Limited Time!</span>
        <span class="flash-timer">⏰ Ends: {{ \Carbon\Carbon::parse($flashSale['ends_at'])->format('d M Y, h:i A') }}</span>
    </div>
    @endif

    {{-- Tiered Discount Banner --}}
    @if($tiered['pct'] > 0)
    <div class="tier-banner">
        🏆 Loyalty Discount Applied: {{ $tiered['label'] }}
    </div>
    @else
    <div class="tier-banner" style="background:linear-gradient(90deg,#334155,#1e293b);opacity:.7">
        💡 Add more items to unlock tiered discounts: Buy 3+ (5% OFF) | Buy 5+ (12% OFF) | Cart >₹500 (10% OFF) | >₹1000 (20% OFF) | >₹2000 (30% OFF)
    </div>
    @endif

    {{-- Analytics Cards --}}
    <div class="analytics">
        <div class="card"><h4>Total Products</h4><h2>{{ $totalProducts }}</h2></div>
        <div class="card"><h4>Total Cart Value</h4><h2>₹{{ number_format($totalValue, 2) }}</h2></div>
        <div class="card"><h4>Total Saved</h4><h2>₹{{ number_format($totalSaved, 2) }}</h2></div>
        <div class="card"><h4>Most Used Coupon</h4><h2>{{ $mostUsedCoupon }}</h2></div>
        @if($tiered['pct'] > 0)
        <div class="card"><h4>Tiered Discount</h4><h2>{{ $tiered['pct'] }}%</h2></div>
        @endif
        @if($flashActive)
        <div class="card"><h4>Flash Discount</h4><h2>{{ $flashSale['discount'] }}%</h2></div>
        @endif
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error-msg">{{ session('error') }}</div>
    @endif

    <div class="search">
        <span>🔍</span>
        <input type="text" id="search" placeholder="Search product by name...">
    </div>

    <div class="table-box">
        <table id="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Coupon</th>
                    <th>Coupon %</th>
                    @if($flashActive)<th>Flash %</th>@endif
                    @if($tiered['pct'] > 0)<th>Tier %</th>@endif
                    <th>Final Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $grand = 0; @endphp
                @foreach($cart as $item)
                @php
                    $subtotal     = $item->price * $item->quantity;
                    $couponAmt    = ($subtotal * $item->coupon_discount) / 100;
                    $flashAmt     = $flashActive ? ($subtotal * $flashSale['discount']) / 100 : 0;
                    $tieredAmt    = ($subtotal * $tiered['pct']) / 100;
                    $totalDisc    = $couponAmt + $flashAmt + $tieredAmt;
                    $final        = $subtotal - $totalDisc;
                    $grand       += $final;
                @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>
                        <form action="/update-qty/{{ $item->id }}" method="POST" class="qty-form">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input">
                            <button type="submit" class="qty-btn">✓</button>
                        </form>
                    </td>
                    <td>₹{{ number_format($subtotal, 2) }}</td>
                    <td>
                        @if($item->coupon)
                            <span class="badge">{{ $item->coupon }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="discount">{{ $item->coupon_discount }}%</td>
                    @if($flashActive)
                        <td><span class="badge badge-flash">{{ $flashSale['discount'] }}%</span></td>
                    @endif
                    @if($tiered['pct'] > 0)
                        <td><span class="badge badge-tier">{{ $tiered['pct'] }}%</span></td>
                    @endif
                    <td>₹{{ number_format($final, 2) }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="/edit/{{ $item->id }}" class="edit">✏️ Edit</a>
                            <a href="/delete/{{ $item->id }}" class="delete" onclick="return confirm('Remove this item?')">🗑 Remove</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-box">
        @if($cart->hasPages())
        <ul class="custom-pagination">
            @if($cart->onFirstPage())
                <li class="disabled">‹</li>
            @else
                <li><a href="{{ $cart->previousPageUrl() }}">‹</a></li>
            @endif
            @for($i = 1; $i <= $cart->lastPage(); $i++)
                @if($i == $cart->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $cart->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor
            @if($cart->hasMorePages())
                <li><a href="{{ $cart->nextPageUrl() }}">›</a></li>
            @else
                <li class="disabled">›</li>
            @endif
        </ul>
        @endif
    </div>

    <div class="total-box">
        <span>Grand Total: ₹{{ number_format($grand, 2) }}</span>
        @if($totalProducts > 0)
            <a href="/checkout" class="checkout-btn">Proceed to Checkout →</a>
        @endif
    </div>

</div>

<script>
    document.getElementById("search").addEventListener("keyup", function () {
        let val = this.value.toLowerCase();
        document.querySelectorAll("#table tbody tr").forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? "" : "none";
        });
    });
</script>
</body>
</html>
