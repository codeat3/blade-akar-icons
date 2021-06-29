<?php

declare(strict_types=1);

namespace Codeat3\BladeAkarIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeAkarIconsServiceProvider extends ServiceProvider {
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-akar-icons', []);

            $factory->add('akar-icons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

}

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-akar-icons.php', 'blade-akar-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-akar-icons'),
            ], 'blade-akar-icons');

            $this->publishes([
                __DIR__.'/../config/blade-akar-icons.php' => $this->app->configPath('blade-akar-icons.php'),
            ], 'blade-akar-icons-config');
        }
    }

}
