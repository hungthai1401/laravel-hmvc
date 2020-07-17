<?php

namespace HT\Modules\Providers;

use HT\Modules\Console\CreateModuleCommand;
use HT\Modules\Console\MakeCommand;
use HT\Modules\Console\MakeController;
use HT\Modules\Console\MakeEvent;
use HT\Modules\Console\MakeFacade;
use HT\Modules\Console\MakeFactory;
use HT\Modules\Console\MakeJob;
use HT\Modules\Console\MakeListener;
use HT\Modules\Console\MakeMigration;
use HT\Modules\Console\MakeModel;
use HT\Modules\Console\MakePolicy;
use HT\Modules\Console\MakeProvider;
use HT\Modules\Console\MakeRepository;
use HT\Modules\Console\MakeRequest;
use HT\Modules\Console\MakeRule;
use HT\Modules\Console\MakeScope;
use HT\Modules\Console\MakeSeeder;
use HT\Modules\Console\MakeService;
use HT\Modules\Console\MakeView;
use HT\Modules\Console\MakeViewComposer;
use HT\Modules\Console\RemoveModuleCommand;
use HT\Modules\Console\RunSeed;
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
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            CreateModuleCommand::class,
            RemoveModuleCommand::class,
            MakeController::class,
            MakeModel::class,
            MakeCommand::class,
            MakeFacade::class,
            MakeMigration::class,
            MakePolicy::class,
            MakeRequest::class,
            MakeView::class,
            MakeViewComposer::class,
            MakeService::class,
            MakeJob::class,
            MakeEvent::class,
            MakeListener::class,
            MakeRule::class,
            MakeSeeder::class,
            MakeFactory::class,
            MakeRepository::class,
            MakeProvider::class,
            MakeScope::class,
            RunSeed::class,
        ]);
    }
}
