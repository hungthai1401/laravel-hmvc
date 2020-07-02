<?php

namespace DummyNamespace\Providers;

use HT\Modules\Providers\AbstractModuleServiceProvider;

/**
 * Provider: ModuleServiceProvider
 * @package DummyNamespace\Providers
 */
class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    /**
     * @return string
     */
    public function getDir(): string
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return 'DummyAlias';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();
        $this->app->register(RouteServiceProvider::class);
    }
}
