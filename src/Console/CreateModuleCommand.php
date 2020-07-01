<?php

namespace HT\Modules\Console;

use Illuminate\Support\Str;
use stdClass;
use Symfony\Component\Process\Process;

/**
 * Command: CreateModuleCommand
 * @package HT\Modules\Console
 */
class CreateModuleCommand extends AbstractModuleCommand
{
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
        $this->container['name'] = Str::slug($this->argument('name'));
        $directory = base_path(sprintf('%s/%s', $this->getModulesDirectory(), $this->container['name']));
        if ($this->files->exists($directory)) {
            $this->error('The module path already exists');
            exit();
        }

        $this->container['path'] = $directory;
        $this->container['authors']['name'] = $this->ask('Author name of module:', config('modules.authors.name'));
        $this->container['authors']['email'] = $this->ask('Author email of module:', config('modules.authors.email'));
        $this->container['description'] = $this->ask('Description of module:', '');
        $this->container['namespace'] = $this->ask(
            'Namespace of module:',
            config('modules.namespace') . '\\' . Str::studly($this->container['name'])
        );
    }

    /**
     * This function will generate module files
     */
    protected function generatingModule(): void
    {
        if (! $this->files->makeDirectory($this->container['path'])) {
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
        $command = 'composer require ' . static::MODULE_TYPE . '/' . $this->container['name'];
        $this->info($command);
        $process = Process::fromShellCommandline($command);
        $process->run();
        $this->info($process->getOutput());
    }

    /**
     * This function will generate composer json
     */
    private function generateComposerJson(): void
    {
        try {
            $composerJson = json_decode($this->files->get($this->container['path'] . '/composer.json'), true);
            $composerJson['name'] = self::MODULE_TYPE . '/' . $this->container['name'];
            $composerJson['description'] = $this->container['description'];
            $composerJson['authors'][] = $this->container['authors'];
            $composerJson['autoload']['psr-4'][$this->container['namespace'] . '\\'] = 'src/';
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
                $filePath = base_path(config('modules.directory') . '/' . $this->container['name'] . '/' . $file->getRelativePathname());

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
            $this->container['name'],
        ];

        return str_replace($find, $replace, $contents);
    }
}
