<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $listen = [
        \App\Events\CommentPosted::class => [
            \App\Listeners\AwardPoints::class,
        ],
        \App\Events\PostLiked::class => [
            \App\Listeners\AwardPoints::class,
        ],
    ];
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
        //
    }
}
