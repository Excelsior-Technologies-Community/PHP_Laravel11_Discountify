# PHP_Laravel11_Discountify

A modern e-commerce helper application built with **Laravel 11** for shopping cart, coupon management, and discount calculation.



## Project Description

PHP_Laravel11_Discountify is a modern e-commerce helper application built with Laravel 11 that demonstrates how to create a shopping cart system with product addition, coupon management, discount calculation, and tax computation.

It allows users to:

- Add multiple products to a cart
- Apply coupons for discounts
- Automatically calculate global and coupon-based discounts
- Display final totals including taxes

This project is ideal for small online stores, demo e-commerce projects, or learning discount systems in Laravel.


## Features

- Add products with price, quantity, and optional coupon codes
- Pre-defined coupons and customizable discount conditions
- Automatic discount calculation based on conditions (e.g., total above ₹500)
- Calculates global discount and tax (GST 18%)
- Clear cart functionality
- Dark mode responsive UI for modern look
- Uses sessions to store cart data


## Technology Stack

- Backend: PHP 8+, Laravel 11
- Frontend: Blade Templates, HTML, CSS (Dark mode)
- Database: MySQL
- Packages: Safemood Discountify for discount management
- Server: Artisan Development Server



---



## Installation Steps


---


## STEP 1: Initialize Laravel Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel11_Discountify "^11.0"

```

### Go inside project:

```
cd PHP_Laravel11_Discountify

```

#### Explanation:

Installs a fresh Laravel 11 project and navigates into the project folder.




## STEP 2: Database Setup (Optional)

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel11_Discountify
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel11_Discountify

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

Connects Laravel to MySQL and creates the default tables needed for the project.




## STEP 3: Install Package 

### Run:

```
composer require safemood/discountify

```

#### Explanation: 

Installs the Discountify package for handling discounts and coupons.





## STEP 4: Publish Config

### Run:

```
php artisan vendor:publish --tag=discountify-config

```


### config/discountify.php

```
<?php

return [

    'condition_namespace' => 'App\\Conditions',

    'condition_path' => app_path('Conditions'),

    'fields' => [
        'price' => 'price',
        'quantity' => 'quantity',
    ],

    'global_discount' => 0,

    'global_tax_rate' => 0,
];

```

#### Explanation: 

Publishes the configuration file so you can customize Discountify settings.

config/discountify.php defines discount fields, global discount, and tax rate.





## STEP 5: Add Conditions 

### app/Providers/AppServiceProvider.php

```
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Safemood\Discountify\Facades\Condition;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

   public function boot(): void
{
    \Safemood\Discountify\Facades\Condition::define('total_above_500', function ($items) {
        $total = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);
        return $total > 500;
    }, 30);
}
}

```

#### Explanation: 

Creates a custom discount condition — 30% discount if total > ₹500.




## STEP 6: Create Cart Controller

### Run:

```
php artisan make:controller CartController

```

### app/Http/Controllers/CartController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function create()
    {
        $availableCoupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME5' => 5
        ];

        return view('create-product', compact('availableCoupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'coupon' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);

        $availableCoupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME5' => 5
        ];

        $coupon = strtoupper($request->coupon ?? '');
        $couponDiscount = $availableCoupons[$coupon] ?? 0;

        if ($couponDiscount === 0) {
            $coupon = null;
        }

        $cart[] = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'coupon' => $coupon,
            'coupon_discount' => $couponDiscount
        ];

        session()->put('cart', $cart);

        return redirect('/cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect('/cart');
    }
}

```

#### Explanation: 

Generates a controller to handle cart actions (add, view, clear).

CartController.php manages cart sessions, product addition, and coupon application.





## STEP 7: Add Routes

### routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', [CartController::class, 'index']);           // Cart Details
Route::get('/create-product', [CartController::class, 'create']); // Show create form
Route::post('/add-product', [CartController::class, 'store']);    // Add product to cart
Route::get('/clear-cart', [CartController::class, 'clear']);      // Clear cart (optional)

```

#### Explanation: 

Defines routes to show cart, add products, and clear cart.




## STEP 8: Create Blade Files

### resources/views/cart.blade.php

```
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

```



### resources/views/product-cart.blade.php

```
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

```

#### Explanation: 

Frontend pages for adding products and showing cart details in dark mode.





## STEP 9: Run the App  

### Start dev server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000/cart

```

#### Explanation:

Starts the development server to test the application.





## Expected Output:


### Cart Overview:


<img src="screenshots/Screenshot 2026-03-26 173604.png" width="900">


### Product Creation Page:


<img src="screenshots/Screenshot 2026-03-26 173647.png" width="900">


### Cart Summary with Applied Coupons:


<img src="screenshots/Screenshot 2026-03-26 173701.png" width="900">



---

## Project Folder Structure

```
PHP_Laravel11_Discountify/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CartController.php      # Handles cart logic
│   └── Providers/
│       └── AppServiceProvider.php      # Defines discount conditions
├── config/
│   └── discountify.php                  # Discountify settings
├── resources/
│   └── views/
│       ├── cart.blade.php              # Cart page
│       └── create-product.blade.php    # Add product page
├── routes/
│   └── web.php                          # Web routes
├── .env                                 # Database & environment settings
└── artisan                               # Laravel CLI

```
