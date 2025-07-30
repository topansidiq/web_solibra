<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.header-guest', function ($view) {
            $view->with([
                'categories' => Category::all(),
                'events' => Event::get(),
            ]);
        });
    }
}
