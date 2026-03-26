<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Professional Cart - Dark Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & Body */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #121212;
            color: #e0e0e0;
        }

        /* Header */
        header {
            background: linear-gradient(90deg, #00bcd4, #0097a7);
            padding: 1.5rem;
            text-align: center;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
            border-bottom: 2px solid #00bcd4;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            color: #121212;
            background: linear-gradient(90deg, #00bcd4, #00e5ff);
            transition: 0.3s;
            margin-right: 0.5rem;
            margin-bottom: 1rem;
        }

        .btn:hover {
            background: linear-gradient(90deg, #0097a7, #00bcd4);
        }

        /* Product Grid */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Product Card */
        .card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
            transition: 0.3s;
            border-left: 4px solid #00bcd4;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.9);
        }

        .card h3 {
            color: #00bcd4;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .card p {
            margin: 0.3rem 0;
            font-size: 1rem;
            color: #cccccc;
        }

        .coupon-badge {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            background: #00e5ff;
            color: #121212;
            font-weight: 600;
            border-radius: 5px;
            font-size: 0.85rem;
            margin-left: 0.5rem;
        }

        /* Summary */
        .summary {
            margin-top: 2rem;
            background: #1e1e1e;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8);
            border-left: 4px solid #00bcd4;
        }

        .summary h2 {
            color: #00bcd4;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Responsive Table-Like Layout inside Card */
        .card-details {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .card-details div {
            width: 48%;
            margin-bottom: 0.5rem;
        }

        /* Subtotal/Discount/Tax Styling */
        .card-details strong {
            color: #fff;
        }
    </style>
</head>

<body>

    <header>🛒 Cart Details</header>
    <div class="container">
        <a href="/create-product" class="btn">➕ Add New Product</a>
        <a href="/clear-cart" class="btn">🗑 Clear Cart</a>

        <h2>Cart Items</h2>
        <div class="products">
            @php $grandTotal = 0; @endphp
            @foreach($cart as $item)
                @php
                    $productTotal = $item['price'] * $item['quantity'];
                    $discount = ($productTotal * 5) / 100; // 5% global discount
                    $couponDiscount = $item['coupon_discount'] ?? 0;
                    $discount += ($productTotal * $couponDiscount) / 100;
                    $totalAfterDiscount = $productTotal - $discount;
                    $tax = ($totalAfterDiscount * 18) / 100;
                    $finalTotal = $totalAfterDiscount + $tax;
                    $grandTotal += $finalTotal;
                @endphp
                <div class="card">
                    <h3>{{ $item['name'] }}
                        @if(!empty($item['coupon']))
                            <span class="coupon-badge">{{ $item['coupon'] }} ({{ $item['coupon_discount'] }}% off)</span>
                        @endif
                    </h3>

                    <div class="card-details">
                        <div><strong>Price:</strong> ₹{{ number_format($item['price'], 2) }}</div>
                        <div><strong>Quantity:</strong> {{ $item['quantity'] }}</div>
                        <div><strong>Subtotal:</strong> ₹{{ number_format($productTotal, 2) }}</div>
                        <div><strong>Discount:</strong> ₹{{ number_format($discount, 2) }}</div>
                        <div><strong>Tax (18%):</strong> ₹{{ number_format($tax, 2) }}</div>
                        <div><strong>Final Total:</strong> ₹{{ number_format($finalTotal, 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="summary">
            <h2>Grand Total: ₹{{ number_format($grandTotal, 2) }}</h2>
        </div>

    </div>
</body>

</html>