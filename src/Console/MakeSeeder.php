<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

/**
 * Command: MakeSeeder
 * @package HT\Modules\Console
 */
class MakeSeeder extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:seed
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->modulePath() . 'database/seeds/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass(string $name): string
    {
        $className = $name;
        if (! Str::endsWith($name, $this->type)) {
            $className = $name . $this->type;
        }

        return $className;
    }
}
