<?php

namespace Asantibanez\LivewireStatusBoard;

use Illuminate\Support\ServiceProvider;

class LivewireStatusBoardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-status-board');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/livewire-status-board'),
            ], 'livewire-status-board-views');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
