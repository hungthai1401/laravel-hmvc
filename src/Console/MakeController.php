<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

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

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        $className = $name;
        if (Str::endsWith('Controller', $name)) {
            $className = $name . 'Controller';
        }

        return 'Controllers\\' . $className;
    }
}
