<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\View;

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
        // Fix for pagination view resolver
        AbstractPaginator::viewFactoryResolver(function () {
            return app('view');
        });

        AbstractPaginator::defaultView('pagination::tailwind');

        View::addNamespace('pagination', resource_path('views/vendor/pagination'));
    }
}
