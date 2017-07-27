<?php

namespace App\Repositories;


use Illuminate\Support\ServiceProvider;

class TreeRepoServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\TreeInterface', 'App\Repositories\TreeRepository');
    }

}