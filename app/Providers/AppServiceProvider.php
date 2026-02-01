<?php

namespace App\Providers;

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
        // Share categories with all views (or specific layout)
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $view->with('categories', \App\Models\Category::where('is_active', true)->take(6)->get());
        });
        
        \Illuminate\Support\Facades\View::composer('home', function ($view) {
             // Home might want its own specific category list, but usually layout covers it.
             // If home needs it for the main content (not just footer), we can leave it to the controller
             // or share it here too if widely used.
        });
    }
}
