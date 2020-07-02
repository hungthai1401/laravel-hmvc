<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/**
 * Command: RemoveModuleCommand
 * @package HT\Modules\Console
 */
class RemoveModuleCommand extends AbstractModuleCommand
{
    /**
     * @var string
     */
    protected $signature = 'module:remove {name : The name of the module}';

    /**
     * @var string
     */
    protected $description = 'Remove the specified module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->getModuleInformation();
        $this->removeModule();
        $this->removeModuleDirectory();
    }

    /**
     * This function will get module information before generate
     */
    protected function getModuleInformation(): void
    {
        if (! $this->confirm('Do you certainly want to remove this module?', true)) {
            exit();
        }

        $this->container['name'] = Str::slug($this->argument('name'));
        $directory = base_path(sprintf('%s/%s', $this->getModulesDirectory(), $this->container['name']));
        if (! $this->files->exists($directory)) {
            $this->error('The module path does not exists');
            exit();
        }

        $this->container['path'] = $directory;
    }

    /**
     * remove module
     */
    protected function removeModule(): void
    {
        $command = 'composer remove ' . static::MODULE_TYPE . '/' . $this->container['name'];
        $this->info($command);
        $process = Process::fromShellCommandline($command);
        $process->run();
        $this->info($process->getOutput());
    }

    /**
     * remove module directory
     */
    protected function removeModuleDirectory(): void
    {
        if (! $this->files->deleteDirectory($this->container['path'])) {
            $this->error('The module path have been not remove');
            exit();
        }
        $this->info('Your module has been removed successfully.');
    }
}
