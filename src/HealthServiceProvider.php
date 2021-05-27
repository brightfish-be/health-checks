<?php

namespace Brightfish\HealthChecks;

use Brightfish\HealthChecks\Commands\HealthCheckCommand;
use Brightfish\HealthChecks\Services\HealthService;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $config = (array)$this->app->make('config')->get('health');

        if ($config['router'] ?? false) {
            $this->bindRoutes($config['router']);
        }

        $this->registerEventListeners($config);

        if ($this->app->runningInConsole()) {
            $this->publishResources();

            $this->commands([
                HealthCheckCommand::class,
            ]);
        }
    }

    /** @inheritDoc */
    public function register()
    {
        $this->mergeConfigFrom(HealthConstants::CONFIG_PATH, 'health');

        $this->app->singleton(HealthService::class, function ($app) {
            $config = $app->make('config')->get('health');

            $checks = $config['checks'] ?? [];

            unset($config['checks']);

            $cache = $this->app->make('cache')->store();

            return new HealthService($checks, $cache, $config);
        });
    }

    /**
     * Register the routes to check the health from the web.
     * @param array $routerConfig
     * @return void
     */
    protected function bindRoutes(array $routerConfig): void
    {
        $controller = $this->isLaravelApp() ? 'HealthController' : 'HealthLumenController';

        $this->app['router']->group([
            'namespace' => '\Brightfish\HealthChecks\Http\Controllers',
        ], function ($router) use ($routerConfig, $controller) {
            $router->get($routerConfig['uri'] ?? HealthConstants::DEFAULT_ROUTE_URI, [
                'uses' => $controller,
                'middleware' => $routerConfig['middleware'] ?? null,
                'as' => 'health.check'
            ]);
        });
    }

    /**
     * Copies files to parent project.
     * @return void
     */
    protected function publishResources(): void
    {
        $isLaravel = $this->isLaravelApp();

        if ($isLaravel) {
            $this->publishes([
                HealthConstants::CONFIG_PATH => config_path('health.php'),
            ], 'health-checks-config');
        }
    }

    /**
     * Check if the current app is a Laravel application, otherwise assuming Lumen.
     * @return bool
     */
    protected function isLaravelApp(): bool
    {
        return $this->app instanceof \Illuminate\Foundation\Application;
    }

    /**
     * Register default listeners.
     * @param array $config
     * @throws BindingResolutionException
     */
    protected function registerEventListeners(array $config): void
    {
        if ($config['log_artisan_time'] ?? true) {
            $this->app
                ->make('events')
                ->listen(CommandStarting::class, function(CommandStarting $event) {
                    $this->app->make(HealthService::class)->setTime($event->command);
                });
        }

        if ($config['log_router_time'] ?? false) {
            $this->app
                ->make('events')
                ->listen(RouteMatched::class, function(Route $route) {
                    $this->app->make(HealthService::class)->setTime(
                        $route->getName() ?? $route->uri() ?? $route->getAction()
                    );
                });
        }
    }
}
