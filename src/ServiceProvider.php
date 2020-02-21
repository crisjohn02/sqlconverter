<?php

namespace Crisjohn02\Sqlconverter;

use Crisjohn02\Sqlconverter\Console\Commands\ConvertDb;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ConvertDb::class
            ]);
        }
    }

    public function register()
    {
        parent::register();
    }
}
