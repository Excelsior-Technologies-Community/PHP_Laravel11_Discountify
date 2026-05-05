<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Add Product</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            margin: 0;
        }

        header {
            background: #00bcd4;
            color: #fff;
            text-align: center;
            padding: 18px;
            font-size: 22px;
            font-weight: 600;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        a.back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #00bcd4;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input:focus {
            border-color: #00bcd4;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #00bcd4;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            background: #0097a7;
        }

        .coupon-box {
            background: #f1faff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .coupon-box strong {
            color: #00bcd4;
        }

        .preview {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
        }

        .error {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>

<header>➕ Add Product</header>

<div class="container">

    <a href="/cart" class="back">← Back to Cart</a>

    <div class="card">

        <form action="/add-product" method="POST" id="form">
            @csrf

            <input type="text" name="name" placeholder="Product Name" required>

            <input type="number" name="price" id="price" placeholder="Price" required>

            <input type="number" name="quantity" id="qty" placeholder="Quantity" required>

            <input type="text" name="coupon" id="coupon" placeholder="Coupon Code (optional)">

            <!-- Coupons -->
            @if(!empty($availableCoupons))
                <div class="coupon-box">
                    Available:
                    @foreach($availableCoupons as $code => $value)
                        <strong>{{ $code }}</strong> ({{ $value }}%)
                        @if(!$loop->last), @endif
                    @endforeach
                </div>
            @endif

            <!-- Preview -->
            <div class="preview" id="preview">
                Total: ₹0
            </div>

            <div class="error" id="error"></div>

            <button class="btn">Add Product</button>
        </form>

    </div>
</div>

<script>
    const price = document.getElementById("price");
    const qty = document.getElementById("qty");
    const coupon = document.getElementById("coupon");
    const preview = document.getElementById("preview");
    const error = document.getElementById("error");

    const coupons = {
        SAVE10: 10,
        SAVE20: 20,
        WELCOME5: 5
    };

    function calculate() {
        let p = parseFloat(price.value) || 0;
        let q = parseInt(qty.value) || 0;
        let total = p * q;

        let c = coupon.value.toUpperCase();
        let discount = 5; // global

        if (c && coupons[c]) {
            discount += coupons[c];
            error.innerText = "";
        } else if (c) {
            error.innerText = "Invalid Coupon!";
        } else {
            error.innerText = "";
        }

        let discountAmount = (total * discount) / 100;
        let final = total - discountAmount;

        preview.innerHTML = `
            Subtotal: ₹${total}<br>
            Discount: ${discount}%<br>
            Final: ₹${final.toFixed(2)}
        `;
    }

    price.addEventListener("input", calculate);
    qty.addEventListener("input", calculate);
    coupon.addEventListener("input", calculate);
</script>

</body>
</html>