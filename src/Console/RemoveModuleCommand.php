<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;

/**
 * Command: RemoveModuleCommand
 * @package HT\Modules\Console
 */
class RemoveModuleCommand extends AbstractModuleCommand
{
    protected const COMPOSER_COMMAND_TYPE = 'remove';

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

        parent::getModuleInformation();
        if (! $this->files->exists($this->container['path'])) {
            $this->error('The module path does not exists');
            exit();
        }
    }

    /**
     * remove module
     */
    protected function removeModule(): void
    {
        $this->runComposerCommand();
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
