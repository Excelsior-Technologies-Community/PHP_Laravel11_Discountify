<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Order Placed!</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{background:linear-gradient(135deg,#0f172a,#1e293b,#0f172a);min-height:100vh;color:#fff;display:flex;align-items:center;justify-content:center;padding:30px}
        .box{max-width:650px;width:100%;background:rgba(255,255,255,.07);backdrop-filter:blur(15px);border:1px solid rgba(255,255,255,.1);border-radius:28px;padding:40px;box-shadow:0 10px 40px rgba(0,0,0,.4);text-align:center}
        .icon{font-size:70px;margin-bottom:20px}
        h1{font-size:30px;font-weight:700;margin-bottom:10px;color:#22c55e}
        .order-id{color:#94a3b8;font-size:14px;margin-bottom:30px}
        .details{background:#1e293b;border-radius:16px;padding:20px;text-align:left;margin-bottom:25px}
        .row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:14px}
        .row:last-child{border-bottom:none}
        .label{color:#94a3b8}
        .value{font-weight:600;color:#e2e8f0}
        .payment-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;background:linear-gradient(90deg,#06b6d4,#3b82f6)}
        .grand{background:linear-gradient(90deg,#06b6d4,#2563eb);padding:18px;border-radius:14px;font-size:22px;font-weight:700;margin-bottom:25px;box-shadow:0 6px 20px rgba(59,130,246,.4)}
        .btn{display:inline-block;padding:14px 30px;background:linear-gradient(90deg,#06b6d4,#3b82f6);color:white;text-decoration:none;border-radius:14px;font-weight:700;font-size:15px;transition:.3s}
        .btn:hover{transform:translateY(-3px);box-shadow:0 8px 25px rgba(6,182,212,.5)}
    </style>
</head>
<body>
<div class="box">
    <div class="icon">🎉</div>
    <h1>Order Placed Successfully!</h1>
    <div class="order-id">Order #{{ $order->id }} · {{ $order->created_at->format('d M Y, h:i A') }}</div>

    <div class="details">
        <div class="row"><span class="label">Name</span><span class="value">{{ $order->name }}</span></div>
        <div class="row"><span class="label">Email</span><span class="value">{{ $order->email }}</span></div>
        <div class="row"><span class="label">Phone</span><span class="value">{{ $order->phone }}</span></div>
        <div class="row"><span class="label">Address</span><span class="value">{{ $order->address }}</span></div>
        <div class="row"><span class="label">Payment</span><span class="value"><span class="payment-badge">{{ strtoupper($order->payment_method) }}</span></span></div>
        <div class="row"><span class="label">Items</span><span class="value">{{ count($order->items) }} product(s)</span></div>
    </div>

    <div class="grand">Total Paid: ₹{{ number_format($order->grand_total, 2) }}</div>

    <a href="/cart" class="btn">🛒 Continue Shopping</a>
</div>
</body>
</html>
