<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Discountify | Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{background:linear-gradient(135deg,#0f172a,#1e293b,#0f172a);min-height:100vh;color:#fff;padding:30px}
        .container{max-width:1200px;margin:auto}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
        .logo{font-size:26px;font-weight:700;background:linear-gradient(to right,#38bdf8,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .back{text-decoration:none;color:white;background:rgba(255,255,255,.1);padding:12px 20px;border-radius:12px;transition:.3s}
        .back:hover{background:#06b6d4}
        .grid{display:grid;grid-template-columns:1fr 420px;gap:30px}
        .card{background:rgba(255,255,255,.07);backdrop-filter:blur(15px);border:1px solid rgba(255,255,255,.1);border-radius:22px;padding:28px;box-shadow:0 8px 30px rgba(0,0,0,.3)}
        h2{font-size:22px;margin-bottom:22px;font-weight:700}
        .input-group{margin-bottom:18px}
        label{display:block;margin-bottom:7px;font-size:13px;color:#cbd5e1}
        input,select,textarea{width:100%;padding:13px;border:none;outline:none;border-radius:12px;background:#1e293b;color:white;font-size:14px;transition:.3s;font-family:'Poppins',sans-serif}
        input:focus,select:focus,textarea:focus{border:1px solid #38bdf8;box-shadow:0 0 12px rgba(6,182,212,.3)}
        select option{background:#1e293b}
        textarea{resize:vertical;min-height:80px}
        .btn{width:100%;padding:15px;border:none;border-radius:14px;cursor:pointer;font-size:15px;font-weight:700;background:linear-gradient(to right,#06b6d4,#3b82f6);color:white;margin-top:10px;transition:.4s}
        .btn:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(6,182,212,.5)}
        .error-field{color:#f87171;font-size:12px;margin-top:4px}

        /* Order Summary */
        .summary-item{background:#1e293b;border-radius:14px;padding:14px;margin-bottom:12px}
        .summary-item .name{font-weight:600;font-size:14px;margin-bottom:8px}
        .summary-row{display:flex;justify-content:space-between;font-size:13px;color:#94a3b8;margin:4px 0}
        .summary-row.final{color:#38bdf8;font-weight:700;font-size:14px;margin-top:8px}
        .badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:#10b981;margin-left:6px}
        .badge-flash{background:linear-gradient(90deg,#f59e0b,#ef4444)}
        .badge-tier{background:linear-gradient(90deg,#7c3aed,#4f46e5)}
        .grand-total{background:linear-gradient(90deg,#06b6d4,#2563eb);padding:20px;border-radius:16px;font-size:22px;font-weight:700;text-align:center;margin-top:20px;box-shadow:0 6px 20px rgba(59,130,246,.4)}

        .flash-banner{background:linear-gradient(90deg,#f59e0b,#ef4444);padding:12px 18px;border-radius:14px;margin-bottom:20px;font-weight:600;font-size:14px}
        .tier-banner{background:linear-gradient(90deg,#7c3aed,#4f46e5);padding:12px 18px;border-radius:14px;margin-bottom:20px;font-weight:600;font-size:14px}

        @media(max-width:900px){.grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">Discountify</div>
        <a href="/cart" class="back">← Back to Cart</a>
    </div>

    @if($flashActive)
    <div class="flash-banner">⚡ Flash Sale {{ $flashSale['discount'] }}% OFF applied on all items!</div>
    @endif
    @if($tiered['pct'] > 0)
    <div class="tier-banner">🏆 {{ $tiered['label'] }} applied!</div>
    @endif

    <div class="grid">

        {{-- Checkout Form --}}
        <div class="card">
            <h2>📦 Delivery & Payment</h2>
            <form action="/place-order" method="POST">
                @csrf
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                    @error('name')<div class="error-field">{{ $message }}</div>@enderror
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                    @error('email')<div class="error-field">{{ $message }}</div>@enderror
                </div>
                <div class="input-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number" required>
                    @error('phone')<div class="error-field">{{ $message }}</div>@enderror
                </div>
                <div class="input-group">
                    <label>Delivery Address</label>
                    <textarea name="address" placeholder="Full delivery address..." required>{{ old('address') }}</textarea>
                    @error('address')<div class="error-field">{{ $message }}</div>@enderror
                </div>
                <div class="input-group">
                    <label>Payment Method</label>
                    <select name="payment_method" required>
                        <option value="">-- Select --</option>
                        <option value="cod"  {{ old('payment_method') == 'cod'  ? 'selected' : '' }}>💵 Cash on Delivery</option>
                        <option value="upi"  {{ old('payment_method') == 'upi'  ? 'selected' : '' }}>📱 UPI</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>💳 Credit / Debit Card</option>
                    </select>
                    @error('payment_method')<div class="error-field">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn">✅ Place Order — ₹{{ number_format($grandTotal, 2) }}</button>
            </form>
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="card">
                <h2>🧾 Order Summary</h2>
                @foreach($items as $item)
                <div class="summary-item">
                    <div class="name">
                        {{ $item['name'] }}
                        @if($item['coupon']) <span class="badge">{{ $item['coupon'] }}</span> @endif
                        @if($item['flash_pct'] > 0) <span class="badge badge-flash">⚡{{ $item['flash_pct'] }}%</span> @endif
                        @if($item['tiered_pct'] > 0) <span class="badge badge-tier">🏆{{ $item['tiered_pct'] }}%</span> @endif
                    </div>
                    <div class="summary-row"><span>Price × Qty</span><span>₹{{ $item['price'] }} × {{ $item['quantity'] }}</span></div>
                    <div class="summary-row"><span>Subtotal</span><span>₹{{ number_format($item['subtotal'], 2) }}</span></div>
                    @if($item['coupon_pct'] > 0)
                    <div class="summary-row"><span>Coupon ({{ $item['coupon_pct'] }}%)</span><span>-₹{{ number_format(($item['subtotal'] * $item['coupon_pct']) / 100, 2) }}</span></div>
                    @endif
                    @if($item['flash_pct'] > 0)
                    <div class="summary-row"><span>Flash Sale ({{ $item['flash_pct'] }}%)</span><span>-₹{{ number_format(($item['subtotal'] * $item['flash_pct']) / 100, 2) }}</span></div>
                    @endif
                    @if($item['tiered_pct'] > 0)
                    <div class="summary-row"><span>Tier Discount ({{ $item['tiered_pct'] }}%)</span><span>-₹{{ number_format(($item['subtotal'] * $item['tiered_pct']) / 100, 2) }}</span></div>
                    @endif
                    <div class="summary-row"><span>Tax (18% GST)</span><span>+₹{{ number_format($item['tax'], 2) }}</span></div>
                    <div class="summary-row final"><span>Item Total</span><span>₹{{ number_format($item['final'], 2) }}</span></div>
                </div>
                @endforeach
                <div class="grand-total">Grand Total: ₹{{ number_format($grandTotal, 2) }}</div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
