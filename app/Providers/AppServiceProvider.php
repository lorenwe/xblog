<?php

namespace App\Providers;

use App\Http\Repositories\MapRepository;
use App\Observers\PageObserver;
use App\Observers\PostObserver;
use App\Page;
use App\Post;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        Page::observe(PageObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('XblogConfig', function ($app) {
            return new MapRepository();
        });
    }
}
