<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; background:#f5f7fa; }
        .box { max-width:500px; margin:40px auto; background:#fff; padding:20px; border-radius:10px; }
        input { width:100%; padding:10px; margin-bottom:10px; }
        button { padding:10px; background:#00bcd4; border:none; color:#fff; width:100%; }
    </style>
</head>
<body>

<div class="box">
    <h2>Edit Product</h2>

    <form method="POST" action="/update/{{ $product->id }}">
        @csrf
        <input type="text" name="name" value="{{ $product->name }}">
        <input type="number" name="price" value="{{ $product->price }}">
        <input type="number" name="quantity" value="{{ $product->quantity }}">
        <input type="text" name="coupon" value="{{ $product->coupon }}">

        <button>Update</button>
    </form>
</div>

</body>
</html>