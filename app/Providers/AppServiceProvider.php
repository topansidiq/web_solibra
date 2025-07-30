<?php

namespace App\Providers;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        // Force Laravel to recognize pagination:: views
        $paginationPath = resource_path('views/vendor/pagination');
        View::addNamespace('pagination', $paginationPath);

        // Set viewFactory resolver explicitly
        AbstractPaginator::viewFactoryResolver(function () {
            return View::getFacadeRoot();
        });

        // (Jika pakai localization views)
        $locale = app()->getLocale();
        View::addLocation(resource_path("views/{$locale}"));
    }
}