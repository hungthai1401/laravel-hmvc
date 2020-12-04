<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

/**
 * Command: RunSeed
 * @package HT\Modules\Console
 */
class RunSeed extends AbstractRunCommand
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
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            parent::handle();
            $this->moduleSeed();
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
            exit();
        }
    }

    /**
     * module seed
     */
    public function moduleSeed(): void
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
    protected function dbSeed($class): void
    {
        $this->call('db:seed', ['--class' => $class]);
    }
}
