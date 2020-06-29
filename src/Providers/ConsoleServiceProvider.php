<?php

namespace HT\Modules\Providers;

use HT\Modules\Console\CreateModuleCommand;
use HT\Modules\Console\MakeController;
use HT\Modules\Console\MakeModel;
use HT\Modules\Console\RemoveModuleCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Provider: ConsoleServiceProvider
 * @package HT\Modules\Providers
 */
class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            CreateModuleCommand::class,
            RemoveModuleCommand::class,
            MakeController::class,
            MakeModel::class,
        ]);
    }
}
