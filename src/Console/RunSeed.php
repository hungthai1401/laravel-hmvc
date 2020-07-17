<?php

namespace HT\Modules\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

/**
 * Command: RunSeed
 * @package HT\Modules\Console
 */
class RunSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:db:seed
    	{module : The alias of the module}
    	{--class= : The specified seeder need to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database seeder from the specified module.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->moduleName = $this->getModuleName();
            if (! $this->moduleExists()) {
                $this->error('Module ' . $this->getModuleName() . ' does not exists!');

                return;
            }
            $this->moduleSeed();
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
            exit();
        }
    }

    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return trim($this->argument('module'));
    }

    /**
     * @return bool
     */
    protected function moduleExists(): bool
    {
        return $this->files->exists($this->modulePath());
    }

    /**
     * @return string
     */
    protected function modulePath(): string
    {
        return base_path(config('modules.directory') . '/' . $this->moduleName . '/');
    }

    /**
     * module seed
     */
    public function moduleSeed()
    {
        $result = [];
        if ($option = $this->option('class')) {
            $result[] = $option;
        } else {
            $seeders = $this->files->allFiles($this->modulePath() . '/database/seeds');
            foreach ($seeders as $seeder) {
                $result[] = Str::replaceArray('.php', [''], $seeder->getFilename());
            }
        }
        if (count($result) > 0) {
            array_walk($result, [$this, 'dbSeed']);
            $this->info("Module [{$this->getModuleName()}] seeded.");
        }
    }

    /**
     * Seed the specified module.
     *
     * @param string $class
     */
    protected function dbSeed($class)
    {
        $this->call('db:seed', ['--class' => $class]);
    }
}
