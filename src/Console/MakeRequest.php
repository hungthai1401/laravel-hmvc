<?php

namespace HT\Modules\Console;

/**
 * Command: MakeRequest
 * @package HT\Modules\Console
 */
class MakeRequest extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:request
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/request.stub';
    }
}
