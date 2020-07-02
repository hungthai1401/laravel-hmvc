<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2020-07-01
 * Time: 23:12
 */

namespace HT\Modules\Console;


use Illuminate\Support\Str;

class MakeFactory extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:factory
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new factory for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/factory.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->modulePath() . 'database/factories/' . str_replace('\\', '/', $name) . '.php';
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
