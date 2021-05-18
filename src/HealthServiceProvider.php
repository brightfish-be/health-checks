<?php

namespace Brightfish\HealthChecks;

use Brightfish\HealthChecks\Commands\HealthCheckCommand;
use Brightfish\HealthChecks\Services\HealthService;
use Illuminate\Contracts\Container\BindingResolutionException;
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
        $config = $this->app->make('config')->get('health');

        if ($config['router'] ?? false) {
            $this->bindRoutes($config['router']);
        }

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

            return new HealthService($checks, $config);
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
}
