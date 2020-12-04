<?php

namespace HT\Modules\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/**
 * Command: AbstractModuleCommand
 * @package HT\Modules\Console
 */
abstract class AbstractModuleCommand extends Command
{
    /**
     * Module type
     */
    protected const MODULE_TYPE = 'modules';

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
    protected function getModuleInformation(): void
    {
        if (Str::contains($this->argument('name'), '/')) {
            [$path, $name] = explode('/', $this->argument('name'));
        } else {
            $name = $this->argument('name');
            $path = null;
        }
        $this->container['name'] = $name;
        $this->container['subPath'] = $path;
        $this->container['path'] = base_path(implode('/', array_filter([$this->getModulesDirectory(), $this->container['subPath'], $this->container['name']])));
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getModulesDirectory()
    {
        return config('modules.directory');
    }

    /**
     * @return string
     */
    protected function getComposerCommandType(): string
    {
        return static::COMPOSER_COMMAND_TYPE;
    }

    /**
     * Run composer command
     */
    protected function runComposerCommand(): void
    {
        $command = "composer {$this->getComposerCommandType()} " . self::MODULE_TYPE . '/' . $this->getPackageName();
        $this->info($command);
        $process = Process::fromShellCommandline('COMPOSER_MEMORY_LIMIT=-1 ' . $command);
        $process->run();
        $this->info($process->getOutput());
    }

    /**
     * @return string
     */
    protected function getPackageName(): string
    {
        return implode('-', array_filter([$this->container['subPath'], $this->container['name']]));
    }
}
