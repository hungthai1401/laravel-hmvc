<?php

namespace HT\Modules\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AbstractRunCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

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
     */
    public function handle(): void
    {
        $this->moduleName = $this->getModuleName();
        if (! $this->moduleExists()) {
            $this->error('Module ' . $this->getModuleName() . ' does not exists!');
            exit();
        }
    }

    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return trim($this->argument('module'));
    }

    /**
     * @return bool
     */
    protected function moduleExists(): bool
    {
        return $this->files->exists($this->modulePath());
    }

    /**
     * @return string
     */
    protected function modulePath(): string
    {
        return base_path(config('modules.directory') . '/' . $this->moduleName . '/');
    }
}
