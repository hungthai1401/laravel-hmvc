<?php

namespace HT\Modules\Console;

/**
 * Command: MakeView
 * @package HT\Modules\Console
 */
class MakeView extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:view
    	{module : The alias of the module}
    	{name : The view name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->modulePath() . 'resources/views/' . str_replace('\\', '/', $name) . '.blade.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/view.stub';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        return $name;
    }

    /**
     * @param $stub
     * @return string|string[]
     */
    protected function replaceParameters($stub)
    {
        $stub = str_replace([
            '{module}',
        ], [
            $this->getModuleName(),
        ], $stub);

        return $stub;
    }
}
