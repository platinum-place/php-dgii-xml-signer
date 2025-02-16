<?php

namespace App\Providers;

use App\Services\SignManager\SignManagerInterface;
use App\Services\SignManager\SignManagerService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    protected $services = [
        SignManagerInterface::class => SignManagerService::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->services as $interface => $service) {
            $this->app->singleton($interface, $service);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
