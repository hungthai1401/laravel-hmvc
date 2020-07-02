<?php

namespace HT\Modules\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * Provider: AbstractModuleServiceProvider
 * @package HT\Modules\Providers
 */
abstract class AbstractModuleServiceProvider extends ServiceProvider
{
    /**
     * Public assets
     */
    const PUBLISH_ASSETS = 'assets';

    /**
     * Publish public assets
     */
    const PUBLISH_PUBLIC_ASSETS = 'public-assets';

    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot(): void
    {
        $moduleName = $this->getModuleName();
        $dir = $this->getDir();
        $this->loadViewsFrom($dir . '/../../resources/views', $moduleName);
        $this->loadTranslationsFrom($dir . '/../../resources/lang', $moduleName);
        $this->loadMigrationsFrom($dir . '/../../database/migrations');
        $this->publishAssets();
    }

    /**
     * Register any module services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadModuleHelpers();
        $this->mergeModuleConfig();
    }

    /**
     * @return string
     */
    abstract public function getModuleName(): string;

    /**
     * @return string
     */
    abstract public function getDir(): string;

    /**
     * This function will publish assets of this module
     *
     * @return void
     */
    protected function publishAssets(): void
    {
        $moduleName = $this->getModuleName();

        $dir = $this->getDir();

        $this->publishes([
            $dir . '/../../resources/views' => config('view.paths')[0] . '/vendor/' . $moduleName,
        ], 'views');

        $this->publishes([
            $dir . '/../../resources/lang' => base_path('resources/lang/vendor/' . $moduleName),
        ], 'lang');

        $this->publishes([
            $dir . '/../../config' => base_path('config'),
        ], 'config');

        $this->publishes([
            $dir . '/../../resources/assets' => resource_path('assets'),
        ], static::PUBLISH_ASSETS);

        $this->publishes([
            $dir . '/../../resources/root' => base_path(),
            $dir . '/../../resources/public' => public_path(),
        ], static::PUBLISH_PUBLIC_ASSETS);
    }

    /**
     * This function will load all helpers of this module
     *
     * @return void
     */
    protected function loadModuleHelpers(): void
    {
        $helpers = File::glob($this->getDir() . '/../../helpers/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }

    /**
     * This function will merge all configs of this module
     *
     * @return void
     */
    protected function mergeModuleConfig(): void
    {
        $configs = $this->splitFilesWithBasename($this->app['files']->glob($this->getDir() . '/../../config/*.php'));
        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }
    }

    /**
     * @param array $files
     * @param string $suffix
     * @return array
     */
    protected function splitFilesWithBasename(array $files, string $suffix = '.php'): array
    {
        $result = [];
        foreach ($files as $row) {
            $baseName = basename($row, $suffix);
            $result[$baseName] = $row;
        }

        return $result;
    }
}
