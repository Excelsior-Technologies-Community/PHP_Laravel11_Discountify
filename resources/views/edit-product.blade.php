<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discountify | Edit Product</title>

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
                linear-gradient(135deg,
                    #0f172a,
                    #1e293b,
                    #0f172a);
            min-height: 100vh;
            color: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
        }

        .logo {
            font-size: 30px;
            font-weight: 700;
            background:
                linear-gradient(to right,
                    #38bdf8,
                    #06b6d4);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            padding: 12px 22px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(10px);
            transition: .3s;
        }

        .back-btn:hover {
            background: #06b6d4;
            transform: translateY(-3px);
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 30px;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, .4);
        }

        h2 {
            margin-bottom: 25px;
            font-size: 28px;
        }

        .group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-size: 14px;
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
            border: 1px solid #38bdf8;
            box-shadow: 0 0 15px #06b6d4;
            transform: scale(1.02);
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            cursor: pointer;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;

            background:
                linear-gradient(to right,
                    #06b6d4,
                    #3b82f6);

            color: white;
            margin-top: 15px;
            transition: .4s;
        }

        .btn:hover {

            transform: translateY(-3px);

            box-shadow:
                0 10px 30px rgba(6, 182, 212, .4);

        }

        .coupon-box {

            background: #1e293b;
            border-left: 5px solid #38bdf8;
            padding: 18px;
            border-radius: 15px;
            margin-bottom: 20px;

        }

        .coupon-box h3 {
            margin-bottom: 15px;
        }

        .coupon {

            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);

        }

        .coupon strong {
            color: #38bdf8;
            font-size: 17px;
        }

        .preview {

            margin-top: 20px;

            background:
                linear-gradient(135deg,
                    #1e293b,
                    #0f172a);

            padding: 25px;
            border-radius: 20px;

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

        <a href="/cart" class="back-btn">
            ← Back
        </a>

    </div>



    <div class="container">


        <div class="card">

            <h2>Edit Product</h2>

            <form method="POST" action="/update/{{ $product->id }}">

                @csrf

                <div class="group">
                    <label>Product Name</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ $product->name }}"
                        required>
                </div>


                <div class="group">

                    <label>Price</label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ $product->price }}"
                        required>

                </div>


                <div class="group">

                    <label>Quantity</label>

                    <input
                        type="number"
                        id="qty"
                        name="quantity"
                        value="{{ $product->quantity }}"
                        required>

                </div>


                <div class="group">

                    <label>Coupon</label>

                    <input
                        type="text"
                        id="coupon"
                        name="coupon"
                        value="{{ $product->coupon }}"
                        placeholder="SAVE10">

                </div>


                <button class="btn">
                    Update Product
                </button>

            </form>

        </div>



        <div>

            <div class="card">

                <div class="coupon-box">

                    <h3>Available Coupons</h3>

                    <div class="coupon">
                        <strong>SAVE10</strong><br>
                        10% OFF <br>
                        Minimum ₹300
                    </div>

                    <div class="coupon">
                        <strong>SAVE20</strong><br>
                        20% OFF <br>
                        Minimum ₹1000
                    </div>

                    <div class="coupon">
                        <strong>WELCOME5</strong><br>
                        5% OFF <br>
                        Minimum ₹100
                    </div>

                </div>


                <div class="preview">

                    <h3>Live Summary</h3>

                    <div class="row">
                        <span>Subtotal</span>
                        <span id="subtotal">
                            ₹0
                        </span>
                    </div>


                    <div class="row">

                        <span>Discount</span>

                        <span id="discount">
                            0%
                        </span>

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
        const price =
            document.getElementById("price");

        const qty =
            document.getElementById("qty");

        const coupon =
            document.getElementById("coupon");

        const subtotal =
            document.getElementById("subtotal");

        const discount =
            document.getElementById("discount");

        const final =
            document.getElementById("final");


        const coupons = {

            SAVE10: 10,
            SAVE20: 20,
            WELCOME5: 5

        };


        function calculate() {

            let p =
                parseFloat(
                    price.value
                ) || 0;

            let q =
                parseInt(
                    qty.value
                ) || 0;

            let total =
                p * q;


            let c =
                coupon.value
                .toUpperCase();


            let d =
                coupons[c] || 0;


            let discountAmount =
                (total * d) / 100;


            let grand =
                total - discountAmount;


            subtotal.innerHTML =
                "₹" + total;


            discount.innerHTML =
                d + "%";


            final.innerHTML =
                "₹" + grand.toFixed(2);

        }

        calculate();

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