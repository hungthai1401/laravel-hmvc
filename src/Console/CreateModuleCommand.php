<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;
use stdClass;

/**
 * Command: CreateModuleCommand
 * @package HT\Modules\Console
 */
class CreateModuleCommand extends AbstractModuleCommand
{
    protected const COMPOSER_COMMAND_TYPE = 'require';

    /**
     * @var string
     */
    protected $signature = 'module:create {name : The name of the module}';

    /**
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->createModulesDirectoryIfNotExists();
        $this->getModuleInformation();
        $this->generatingModule();
    }

    /**
     * This function will create modules directory
     */
    protected function createModulesDirectoryIfNotExists(): void
    {
        $modulesDirectory = $this->getModulesDirectory();
        if (!$this->files->exists(base_path($modulesDirectory))) {
            $this->files->makeDirectory($modulesDirectory);
        }
    }

    /**
     * This function will get module information before generate
     */
    protected function getModuleInformation(): void
    {
        parent::getModuleInformation();
        if ($this->files->exists($this->container['path'])) {
            $this->error('The module path already exists');
            exit();
        }

        $this->container['authors']['name'] = $this->ask('Author name of module:', config('modules.authors.name'));
        $this->container['authors']['email'] = $this->ask('Author email of module:', config('modules.authors.email'));
        $this->container['description'] = $this->ask('Description of module:', '');
        $this->container['namespace'] = $this->ask(
            'Namespace of module:',
            implode('\\', array_filter([ config('modules.namespace'), Str::studly($this->container['subPath']), Str::studly($this->container['name'])]))
        );
    }

    /**
     * This function will generate module files
     */
    protected function generatingModule(): void
    {
        if (! $this->files->makeDirectory($this->container['path'], 0755, true)) {
            $this->error('The module path can not be created');
            exit();
        }

        $source = __DIR__ . '/stubs';
        if (! $this->files->copyDirectory($source, $this->container['path'])) {
            $this->error('The stubs can not be copied to module path');
            exit();
        }

        $this->generateComposerJson();
        $this->installModule();
        $this->info('Your module has been generated successfully.');
    }

    /**
     * install module
     */
    protected function installModule(): void
    {
        $this->runComposerCommand();
    }

    /**
     * This function will generate composer json
     */
    private function generateComposerJson(): void
    {
        try {
            $composerJson = json_decode($this->files->get($this->container['path'] . '/composer.json'), true);
            $composerJson['name'] = self::MODULE_TYPE . '/' . $this->getPackageName();
            $composerJson['description'] = $this->container['description'];
            $composerJson['authors'][] = $this->container['authors'];
            $composerJson['autoload']['psr-4'][$this->container['namespace'] . '\\'] = 'src/';
            $composerJson['autoload']['classmap'] = [['database/factories', 'database/seeds']];
            $composerJson['require'] = new stdClass();
            $composerJson['require-dev'] = new stdClass();
            $composerJson['extra']['laravel']['providers'] = $this->container['namespace'] . '\\Providers\\ModuleServiceProvider';
            $this->files->put($this->container['path'] . '/composer.json', json_encode_prettify($composerJson));

            /**
             * Replace files placeholder
             */
            $files = $this->files->allFiles($this->container['path']);
            foreach ($files as $file) {
                $contents = $this->replacePlaceholders($file->getContents());
                $filePath = $this->container['path'] . '/' . $file->getRelativePathname();
                $this->files->put($filePath, $contents);
            }
        } catch (\Throwable $exception) {
            $this->files->deleteDirectory($this->container['path']);
            $this->error($exception->getMessage());
            exit();
        }
    }

    /**
     * @param $contents
     * @return mixed
     */
    private function replacePlaceholders($contents)
    {
        $find = [
            'DummyNamespace',
            'DummyAlias',
        ];

        $replace = [
            $this->container['namespace'],
            Str::replaceArray('-', ['/'], $this->getPackageName()),
        ];

        return str_replace($find, $replace, $contents);
    }
}
