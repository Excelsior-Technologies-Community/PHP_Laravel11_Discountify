<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Safemood\Discountify\Facades\Condition;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Tiered Discount Rules (Loyalty Scale)
        // Tier 1: Total > ₹500 → 10% OFF
        Condition::define('tier_above_500', function ($items) {
            return collect($items)->sum(fn($i) => $i['price'] * $i['quantity']) > 500;
        }, 10);

        // Tier 2: Total > ₹1000 → 20% OFF (overrides tier 1)
        Condition::define('tier_above_1000', function ($items) {
            return collect($items)->sum(fn($i) => $i['price'] * $i['quantity']) > 1000;
        }, 20);

        // Tier 3: Total > ₹2000 → 30% OFF (overrides tier 2)
        Condition::define('tier_above_2000', function ($items) {
            return collect($items)->sum(fn($i) => $i['price'] * $i['quantity']) > 2000;
        }, 30);

        // Quantity-based Tiered Rules
        // Buy 3+ items → 5% OFF
        Condition::define('qty_buy_3', function ($items) {
            return collect($items)->sum(fn($i) => $i['quantity']) >= 3;
        }, 5);

        // Buy 5+ items → 12% OFF (overrides qty_buy_3)
        Condition::define('qty_buy_5', function ($items) {
            return collect($items)->sum(fn($i) => $i['quantity']) >= 5;
        }, 12);
    }
}
