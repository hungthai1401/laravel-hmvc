<?php

namespace HT\Modules\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Command: AbstractModuleCommand
 * @package HT\Modules\Console
 */
abstract class AbstractModuleCommand extends Command
{
    /**
     * Module type
     */
    const MODULE_TYPE = 'modules';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * CreateModuleCommand constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    abstract public function handle(): void;

    /**
     * This function will get module information before generate
     */
    abstract protected function getModuleInformation(): void;

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getModulesDirectory()
    {
        return config('modules.directory');
    }
}
