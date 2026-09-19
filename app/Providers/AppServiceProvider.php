<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\OrderDetail;
use App\Observers\OrderDetailObserver;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OrderDetail::observe(OrderDetailObserver::class);
        Broadcast::routes();
        require base_path('routes/channels.php');

        Paginator::useBootstrapFive();
    }


}
