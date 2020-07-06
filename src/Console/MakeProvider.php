<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

/**
 * Command: MakeProvider
 * @package HT\Modules\Console
 */
class MakeProvider extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:provider
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service provider for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Provider';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/provider.stub';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        $className = $name;
        $type = 'ServiceProvider';
        if (! Str::endsWith($name, $type)) {
            $className = $name . $type;
        }

        return  'Providers\\' . $className;
    }
}
