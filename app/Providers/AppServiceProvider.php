<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // Laravel ships Tailwind pagination markup, but the only paginated
        // screens are in the Bootstrap-based admin, which never loads Tailwind —
        // so the links rendered unstyled with full-size SVG arrows.
        Paginator::useBootstrapFive();
    }
}
