<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .top {
            display:flex;
            justify-content:space-between;
            margin:20px 0;
        }

        .btn {
            padding:8px 14px;
            background:#00bcd4;
            color:#fff;
            text-decoration:none;
            border-radius:6px;
        }

        input.search {
            padding:8px;
            width:250px;
        }

        table {
            width:100%;
            background:#fff;
            border-radius:10px;
            overflow:hidden;
        }

        th, td {
            padding:12px;
            text-align:center;
        }

        th {
            background:#00bcd4;
            color:#fff;
        }

        tr:nth-child(even) {
            background:#f9f9f9;
        }

        .action a {
            margin:0 5px;
        }
    </style>

</head>
<body>

<div class="container">

    <div class="top">
        <div>
            <a href="/create-product" class="btn">Add Product</a>
            <a href="/clear-cart" class="btn">Clear</a>
        </div>

        <input type="text" id="search" class="search" placeholder="Search...">
    </div>

    <table id="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Coupon</th>
                <th>Final</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @php $grand=0; @endphp

            @foreach($cart as $i => $item)
                @php
                    $total = $item->price * $item->quantity;
                    $discount = ($total * (5 + $item->coupon_discount))/100;
                    $final = $total - $discount;
                    $grand += $final;
                @endphp

                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $total }}</td>
                    <td>{{ $item->coupon ?? '-' }}</td>
                    <td>{{ $final }}</td>

                    <td>
                        <a href="/edit/{{ $item->id }}">Edit</a>
                        <a href="/delete/{{ $item->id }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Grand Total: ₹{{ $grand }}</h2>

</div>

<script>
document.getElementById("search").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#table tbody tr");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});
</script>

</body>
</html>