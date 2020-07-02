<?php

namespace HT\Modules\Console;

/**
 * Command: MakeController
 * @package HT\Modules\Console
 */
class MakeController extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:controller
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/controller.stub';
    }
}
