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