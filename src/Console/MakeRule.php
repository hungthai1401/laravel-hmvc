<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2020-07-01
 * Time: 22:59
 */

namespace HT\Modules\Console;

/**
 * Command: MakeRule
 * @package HT\Modules\Console
 */
class MakeRule extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:rule
    	{module : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new rule for the specified module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Rule';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/partial_stubs/rule.stub';
    }
}
