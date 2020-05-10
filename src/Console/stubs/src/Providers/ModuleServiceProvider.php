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
    public function getDir()
    {
        return __DIR__;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return 'DummyAlias';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->app->register(RouteServiceProvider::class);
    }
}
