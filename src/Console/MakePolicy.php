<?php

namespace HT\Modules\Console;

/**
 * Command: MakePolicy
 * @package HT\Modules\Console
 */
class MakePolicy extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:policy
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/policy.stub';
    }
}
