<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discountify | Add Product</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(135deg, #0f172a, #1e293b, #0f172a);
            min-height: 100vh;
            color: #fff;
        }

        .header {
            padding: 25px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(to right, #38bdf8, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .back {
            text-decoration: none;
            color: white;
            background: rgba(255, 255, 255, .1);
            padding: 12px 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: .3s;
        }

        .back:hover {
            transform: translateY(-3px);
            background: #06b6d4;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, .06);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 25px;
            padding: 30px;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, .3);
        }

        h2 {
            margin-bottom: 25px;
            font-size: 28px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 15px;
            border: none;
            outline: none;
            border-radius: 14px;
            background: #1e293b;
            color: white;
            font-size: 15px;
            transition: .3s;
        }

        input:focus {
            transform: scale(1.02);
            border: 1px solid #38bdf8;
            box-shadow: 0 0 15px #06b6d4;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            background:
                linear-gradient(to right,
                    #06b6d4,
                    #3b82f6);
            color: white;
            margin-top: 10px;
            transition: .4s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, .5);
        }

        .coupon-title {
            margin-bottom: 20px;
            font-size: 20px;
        }

        .coupon {
            background: #1e293b;
            border-left: 5px solid #06b6d4;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: .3s;
        }

        .coupon:hover {
            transform: translateX(8px);
        }

        .coupon-code {
            font-size: 18px;
            font-weight: 700;
            color: #38bdf8;
        }

        .coupon-detail {
            margin-top: 8px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .preview {
            margin-top: 25px;
            background:
                linear-gradient(135deg,
                    #1e293b,
                    #0f172a);

            border-radius: 20px;
            padding: 25px;
        }

        .preview h3 {
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .total {
            font-size: 26px;
            font-weight: 700;
            color: #38bdf8;
            margin-top: 15px;
        }

        .success {
            padding: 15px;
            background: #14532d;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error {
            padding: 15px;
            background: #7f1d1d;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {

            .container {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 20px;
            }

        }
    </style>

</head>

<body>

    <div class="header">

        <div class="logo">
            Discountify
        </div>

        <a href="/cart" class="back">
            ← Back
        </a>

    </div>


    <div class="container">

        <div class="card">

            <h2>Add Product</h2>

            @if(session('success'))
            <div class="success">
                {{session('success')}}
            </div>
            @endif

            @if(session('error'))
            <div class="error">
                {{session('error')}}
            </div>
            @endif


            <form action="/add-product" method="POST">

                @csrf

                <div class="input-group">
                    <label>Product Name</label>
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter product name"
                        required>
                </div>

                <div class="input-group">
                    <label>Price</label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        placeholder="Enter price"
                        required>
                </div>

                <div class="input-group">
                    <label>Quantity</label>
                    <input
                        type="number"
                        name="quantity"
                        id="qty"
                        placeholder="Enter quantity"
                        required>
                </div>

                <div class="input-group">
                    <label>Coupon</label>
                    <input
                        type="text"
                        name="coupon"
                        id="coupon"
                        placeholder="SAVE10">
                </div>

                <button class="btn">
                    Add Product
                </button>

            </form>

        </div>



        <div>

            <div class="card">

                <h3 class="coupon-title">
                    Available Coupons
                </h3>

                @foreach($availableCoupons as $coupon)

                <div class="coupon">

                    <div class="coupon-code">
                        {{$coupon['code']}}
                    </div>

                    <div class="coupon-detail">
                        {{$coupon['discount']}}% OFF
                    </div>

                    <div class="coupon-detail">
                        Min Purchase: ₹{{$coupon['min_purchase']}}
                    </div>

                    <div class="coupon-detail">
                        Expiry: {{$coupon['expiry']}}
                    </div>

                </div>

                @endforeach


                <div class="preview">

                    <h3>Live Summary</h3>

                    <div class="row">
                        <span>Subtotal</span>
                        <span id="subtotal">₹0</span>
                    </div>

                    <div class="row">
                        <span>Discount</span>
                        <span id="discount">0%</span>
                    </div>

                    <div class="row total">
                        <span>Total</span>
                        <span id="final">
                            ₹0
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        const price = document.getElementById("price");
        const qty = document.getElementById("qty");
        const coupon = document.getElementById("coupon");

        const subtotal = document.getElementById("subtotal");
        const discount = document.getElementById("discount");
        const final = document.getElementById("final");


        const coupons = {

            SAVE10: 10,
            SAVE20: 20,
            WELCOME5: 5

        };


        function calculate() {

            let p = parseFloat(price.value) || 0;

            let q = parseInt(qty.value) || 0;

            let total = p * q;

            let c =
                coupon.value.toUpperCase();

            let d =
                coupons[c] || 0;

            let amount =
                (total * d) / 100;

            let grand =
                total - amount;

            subtotal.innerHTML =
                "₹" + total;

            discount.innerHTML =
                d + "%";

            final.innerHTML =
                "₹" + grand.toFixed(2);

        }

        price.addEventListener(
            "input",
            calculate
        );

        qty.addEventListener(
            "input",
            calculate
        );

        coupon.addEventListener(
            "input",
            calculate
        );
    </script>

</body>

</html>