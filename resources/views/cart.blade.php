<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Discountify Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif
        }

        body {
            background: linear-gradient(135deg, #0f172a, #1e293b, #334155);
            min-height: 100vh;
            padding: 30px;
            color: white
        }

        .container {
            max-width: 1350px;
            margin: auto
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px
        }

        .heading h1 {
            font-size: 34px;
            font-weight: 700
        }

        .heading p {
            opacity: .7;
            margin-top: 5px
        }

        .buttons {
            display: flex;
            gap: 12px
        }

        .btn {
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            color: white;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            transition: .3s;
            box-shadow: 0 6px 20px rgba(59, 130, 246, .3)
        }

        .btn:hover {
            transform: translateY(-4px)
        }

        .analytics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px
        }

        .card {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .08);
            padding: 25px;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .25);
            transition: .3s
        }

        .card:hover {
            transform: translateY(-6px)
        }

        .card h4 {
            opacity: .7;
            font-size: 14px;
            margin-bottom: 10px
        }

        .card h2 {
            font-size: 30px;
            font-weight: 700
        }

        .search {
            position: relative;
            margin-bottom: 25px
        }

        .search input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, .08);
            border-radius: 14px;
            color: white;
            font-size: 15px
        }

        .search span {
            position: absolute;
            left: 18px;
            top: 16px;
            opacity: .6
        }

        .table-box {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(16px);
            padding: 20px;
            border-radius: 25px;
            overflow: auto;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .25)
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th {
            padding: 18px;
            font-size: 14px;
            background: rgba(255, 255, 255, .06)
        }

        td {
            padding: 18px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, .06)
        }

        tr:hover {
            background: rgba(255, 255, 255, .03)
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 30px;
            background: #10b981;
            font-size: 12px;
            font-weight: 600
        }

        .discount {
            color: #22c55e;
            font-weight: 700
        }

        .edit {
            padding: 8px 14px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px
        }

        .delete {
            padding: 8px 14px;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            margin-left: 8px
        }

        .total-box {
            margin-top: 25px;
            background: linear-gradient(90deg, #06b6d4, #2563eb);
            padding: 25px;
            border-radius: 22px;
            font-size: 26px;
            font-weight: 700;
            text-align: right;
            box-shadow: 0 8px 30px rgba(59, 130, 246, .4)
        }

        .success {
            padding: 15px;
            margin-bottom: 20px;
            background: #22c55e;
            border-radius: 12px
        }

        /* PREMIUM PAGINATION */

        .pagination-box {
            display: flex;
            justify-content: center;
            margin-top: 35px;
            margin-bottom: 20px;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 14px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-pagination li {
            list-style: none;
        }

        .custom-pagination li a,
        .custom-pagination li span {

            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            text-decoration: none;
            font-weight: 700;
            font-size: 16px;

            color: white;

            background: rgba(255, 255, 255, .08);

            backdrop-filter: blur(20px);

            border: 1px solid rgba(255, 255, 255, .08);

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .25);

            transition: .3s;
        }

        .custom-pagination li a:hover {

            transform: translateY(-4px);

            background:
                linear-gradient(90deg,
                    #06b6d4,
                    #3b82f6);
        }

        .custom-pagination .active span {

            background:
                linear-gradient(90deg,
                    #06b6d4,
                    #3b82f6);
        }

        .custom-pagination .disabled {

            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            opacity: .4;

            background:
                rgba(255, 255, 255, .05);
        }

        @media(max-width:768px) {

            .header {
                flex-direction: column;
                align-items: flex-start
            }

            .buttons {
                width: 100%
            }

            .btn {
                flex: 1;
                text-align: center
            }

        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <div class="heading">
                <h1>Discountify Dashboard</h1>
                <p>Smart Coupon & Cart Analytics System</p>
            </div>

            <div class="buttons">
                <a href="/create-product" class="btn">+ Add Product</a>
                <a href="/clear-cart" class="btn">Clear Cart</a>
            </div>

        </div>

        <div class="analytics">

            <div class="card">
                <h4>Total Products</h4>
                <h2>{{$totalProducts}}</h2>
            </div>

            <div class="card">
                <h4>Total Cart Value</h4>
                <h2>₹{{$totalValue}}</h2>
            </div>

            <div class="card">
                <h4>Total Saved</h4>
                <h2>₹{{$totalSaved}}</h2>
            </div>

            <div class="card">
                <h4>Most Used Coupon</h4>
                <h2>{{$mostUsedCoupon}}</h2>
            </div>

        </div>

        @if(session('success'))
        <div class="success">
            {{session('success')}}
        </div>
        @endif

        <div class="search">
            <span>🔍</span>

            <input
                type="text"
                id="search"
                placeholder="Search product by name...">
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
                        <th>Discount</th>
                        <th>Final Price</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @php $grand=0; @endphp

                    @foreach($cart as $item)

                    @php
                    $total=$item->price*$item->quantity;
                    $discount=($total*$item->coupon_discount)/100;
                    $final=$total-$discount;
                    $grand+=$final;
                    @endphp

                    <tr>

                        <td>{{$item->name}}</td>
                        <td>₹{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>₹{{$total}}</td>

                        <td>

                            @if($item->coupon)

                            <span class="badge">
                                {{$item->coupon}}
                            </span>

                            @else

                            -

                            @endif

                        </td>

                        <td class="discount">
                            {{$item->coupon_discount}}%
                        </td>

                        <td>
                            ₹{{$final}}
                        </td>

                        <td>

                            <a href="/edit/{{$item->id}}" class="edit">
                                Edit
                            </a>

                            <a href="/delete/{{$item->id}}" class="delete">
                                Delete
                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-box">

            @if($cart->hasPages())

            <ul class="custom-pagination">

                {{-- Previous --}}

                @if($cart->onFirstPage())

                <li class="disabled">
                    ‹
                </li>

                @else

                <li>
                    <a href="{{$cart->previousPageUrl()}}">
                        ‹
                    </a>
                </li>

                @endif


                {{-- Page Numbers --}}

                @for($i=1;$i<=$cart->lastPage();$i++)

                    @if($i==$cart->currentPage())

                    <li class="active">
                        <span>{{$i}}</span>
                    </li>

                    @else

                    <li>
                        <a href="{{$cart->url($i)}}">
                            {{$i}}
                        </a>
                    </li>

                    @endif

                    @endfor


                    {{-- Next --}}

                    @if($cart->hasMorePages())

                    <li>
                        <a href="{{$cart->nextPageUrl()}}">
                            ›
                        </a>
                    </li>

                    @else

                    <li class="disabled">
                        ›
                    </li>

                    @endif

            </ul>

            @endif

        </div>

        <div class="total-box">
            Grand Total : ₹{{$grand}}
        </div>

    </div>

    <script>
        document
            .getElementById("search")
            .addEventListener("keyup", function() {

                let value = this.value.toLowerCase();

                let rows = document.querySelectorAll(
                    "#table tbody tr"
                );

                rows.forEach(row => {

                    row.style.display =
                        row.innerText
                        .toLowerCase()
                        .includes(value) ?
                        "" :
                        "none";

                });

            });
    </script>

</body>

</html>