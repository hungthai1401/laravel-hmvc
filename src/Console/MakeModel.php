<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

/**
 * Command: MakeModel
 * @package HT\Modules\Console
 */
class MakeModel extends AbstractGenerator
{
    /**
     * Default primary key
     */
    private const DEFAULT_PRIMARY_KEY = 'id';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:model
    	{module : The alias of the module}
    	{name : The class name}
    	{--table= : Custom table name}
    	{--primary= : Custom primary key}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/model.stub';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        return 'Entities\\' . $this->getNameInput();
    }

    /**
     * @param $stub
     * @return string|string[]
     */
    protected function replaceParameters($stub)
    {
        $tableName = $this->option('table') ?: Str::plural(Str::snake($this->getNameInput()));
        $primaryKey = $this->option('primary') ?: self::DEFAULT_PRIMARY_KEY;
        $stub = str_replace(['{table}', '{primary}'], [$tableName, $primaryKey], $stub);

        return $stub;
    }
}
