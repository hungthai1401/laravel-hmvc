<?php

namespace HT\Modules\Console;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

/**
 * Command: RunMigrate
 * @package HT\Modules\Console
 */
class RunMigrate extends AbstractRunCommand
{
    /**
     * The laravel|lumen application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:db:migrate
    	{module : The alias of the module}
    	{--database= : The database connection to use.}
    	{--pretend : Dump the SQL queries that would be run.}
    	{--force : Force the operation to run when in production.}
    	{--seed : Indicates if the seed task should be re-run.}';

    /**
     * RunMigrate constructor.
     * @param Filesystem $files
     * @param Container $app
     */
    public function __construct(Filesystem $files, Container $app)
    {
        parent::__construct($files);
        $this->app = $app;
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database migrate from the specified module.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            parent::handle();
            $this->moduleMigrate();
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
            exit();
        }
    }

    /**
     * Run the migration from the specified module.
     */
    protected function moduleMigrate(): void
    {
        $path = $this->modulePath();
        $this->call('migrate', [
            '--path' => str_replace(base_path(), '', $path . 'database/migrations'),
            '--database' => $this->option('database') ?? $this->app['config']['database.default'],
            '--pretend' => $this->option('pretend'),
            '--force' => $this->option('force'),
        ]);

        if ($this->option('seed')) {
            $this->call('module:db:seed', ['module' => $this->getModuleName(), '--force' => $this->option('force')]);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['--database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['--pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],
            ['--force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['--seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run.'],
        ];
    }
}
