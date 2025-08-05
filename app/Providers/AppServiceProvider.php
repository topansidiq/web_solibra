<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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

        if (request()->has('lang')) {
            $locale = request()->get('lang');
            Session::put('locale', $locale); // Optional: untuk disimpan antar request
        }

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        AbstractPaginator::viewFactoryResolver(function () {
            return app('view');
        });

        AbstractPaginator::defaultView('pagination::tailwind');

        View::addNamespace('pagination', resource_path('views/vendor/pagination'));
    }
}
