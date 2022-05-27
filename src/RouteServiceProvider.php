<?php

namespace Hito\Module;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Route;

abstract class RouteServiceProvider extends BaseServiceProvider
{
    private array $registeredRoutes = [];

    public function map(): void
    {
        foreach ($this->registeredRoutes as $route) {
            $route();
        }
    }

    protected function registerAdminRoutes(string $path): void
    {
        $this->registeredRoutes[] = function () use ($path) {
            Route::middleware(['web', 'auth'])
                ->name('admin.')
                ->prefix('admin')
                ->group($path);
        };
    }

    protected function registerApiRoutes(string $path): void
    {
        $this->registeredRoutes[] = function () use ($path) {
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group($path);
        };
    }

    protected function registerWebServiceRoutes(string $path): void
    {
        $this->registeredRoutes[] = function () use ($path) {
            Route::middleware('web')
                ->prefix('ws')
                ->name('ws.')
                ->group($path);
        };
    }

    protected function registerWebRoutes(string $path): void
    {
        $this->registeredRoutes[] = function () use ($path) {
            Route::middleware('web')
                ->group($path);
        };
    }
}
