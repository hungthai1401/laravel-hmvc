<?php

namespace HT\Modules\Console;

/**
 * Command: MakeMigration
 * @package HT\Modules\Console
 */
class MakeMigration extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:migration
    	{module : The alias of the module}
    	{name : The class name}
    	{--create=}
    	{--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->moduleName = $this->getModuleName();

        $this->call('make:migration', [
            'name' => $this->getNameInput(),
            '--path' => config('modules.directory') . '/' . $this->moduleName . '/database/migrations',
            '--create' => $this->option('create'),
            '--table' => $this->option('table'),
        ]);

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return '';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        return '';
    }
}
