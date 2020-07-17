<?php

namespace HT\Modules\Console;

/**
 * Command: MakeScope
 * @package HT\Modules\Console
 */
class MakeScope extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:scope
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new scope for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Scope';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/scope.stub';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        return 'Entities\\Scopes\\' . $name;
    }
}
