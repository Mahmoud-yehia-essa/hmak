<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\CheckUserRole; // Import the middleware

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
    public function boot(Kernel $kernel): void
    {
        // Register middleware
        // $kernel->appendMiddlewareToGroup('web', CheckUserRole::class);
        
        view()->composer(['frontend.hmak.body.header', 'frontend.hmak.body.footer'], function ($view) {
            $view->with('newsCategories', \App\Models\NewsCategory::latest()->get());
        });
    }
}
