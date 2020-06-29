<?php

namespace HT\Modules\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Generator: AbstractGenerator
 * @package HT\Modules\Console
 */
abstract class AbstractGenerator extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $moduleType;

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->moduleName = $this->getModuleName();
        if (! $this->moduleExists()) {
            $this->error('Module ' . $this->getModuleName() . ' does not exists!');

            return false;
        }

        $name = $this->parseName($this->getNameInput());

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');

        return true;
    }

    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return trim($this->argument('module'));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput(): string
    {
        return trim($this->argument('name'));
    }

    protected function moduleExists()
    {
        return $this->files->exists($this->modulePath());
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        $name = $this->parseName($rawName);

        return $this->files->exists($this->getPath($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }

    /**
     * @return string
     */
    protected function modulePath(): string
    {
        return base_path(config('modules.directory') . '/' . $this->moduleName . '/');
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param string $name
     * @return string
     */
    protected function parseName($name)
    {
        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->getClass($name);
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $path = $this->modulePath() . 'src/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string|string[]
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            [
                'DummyNamespace',
                'DummyClass',
            ],
            [
                $this->getNamespace($name),
                $this->getClassName($name),
            ],
            $stub
        );

        if (method_exists($this, 'replaceParameters')) {
            $stub = $this->replaceParameters($stub);
        }

        return $stub;
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param string $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $namespace = trim(implode('\\', array_slice(explode('\\', config('modules.namespace') . '\\' . Str::studly($this->getModuleName()) . '\\' . str_replace('/', '\\', $name)), 0, -1)), '\\');

        return $namespace;
    }

    /**
     * @param string $name
     * @return string
     */
    abstract protected function getClass(string $name): string;

    /**
     * @param string $name
     * @return string
     */
    protected function getClassName(string $name): string
    {
        $split = explode('\\', $name);

        return end($split);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    abstract protected function getStub(): string;
}
