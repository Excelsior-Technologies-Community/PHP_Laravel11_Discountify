<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Add Product</title>
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
            font-size: 2rem;
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
            border-bottom: 2px solid #00bcd4;
        }

        /* Container */
        .container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 1rem;
        }

        /* Back Link */
        a {
            display: block;
            margin-bottom: 1rem;
            color: #00bcd4;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        a:hover {
            text-decoration: underline;
            color: #00e5ff;
        }

        /* Form Card */
        .create-form {
            background: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.8);
            border-left: 4px solid #00bcd4;
        }

        /* Inputs */
        input[type=text],
        input[type=number] {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: none;
            background: #222;
            color: #e0e0e0;
            font-size: 1rem;
            transition: 0.3s;
        }

        input[type=text]:focus,
        input[type=number]:focus {
            outline: none;
            box-shadow: 0 0 5px #00bcd4;
        }

        /* Submit Button */
        .btn {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 8px;
            background: linear-gradient(90deg, #00bcd4, #00e5ff);
            font-weight: bold;
            color: #121212;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn:hover {
            background: linear-gradient(90deg, #0097a7, #00bcd4);
        }

        /* Coupons Info */
        .coupons {
            color: #aaaaaa;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .coupons strong {
            color: #00bcd4;
        }
    </style>
</head>

<body>

    <header>➕ Add Product</header>
    <div class="container">
        <a href="/cart">← Back to Cart</a>
        <div class="create-form">
            <form action="/add-product" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="number" name="price" placeholder="Price" required>
                <input type="number" name="quantity" placeholder="Quantity" required>
                <input type="text" name="coupon" placeholder="Coupon Code (optional)">

                @if(!empty($availableCoupons))
                    <div class="coupons">
                        Available Coupons:
                        @foreach($availableCoupons as $code => $value)
                            <strong>{{ $code }}</strong> ({{ $value }}%) @if(!$loop->last),@endif
                        @endforeach
                    </div>
                @endif

                <button class="btn" type="submit">Add Product</button>
            </form>
        </div>
    </div>

</body>

</html>