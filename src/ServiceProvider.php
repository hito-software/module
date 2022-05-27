<?php

namespace Hito\Module;

use Hito\Core\Database\Enums\SeederType;
use Hito\Core\Database\Facades\DatabaseSeeder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class ServiceProvider extends BaseServiceProvider
{
    protected array $registeredMigrations = [];
    protected array $registeredViews = [];
    protected array $registeredTranslations = [];
    protected array $registeredConfig = [];
    protected array $registeredSeeders = [];

    abstract protected function getNamespace(): string;
    abstract protected function configure(): void;

    public function boot(): void
    {
        $this->configure();

        // Load migrations
        foreach ($this->registeredMigrations as $migration) {
            $this->loadMigrationsFrom($migration);
        }

        // Load views
        foreach ($this->registeredViews as $view) {
            $this->loadViewsFrom($view['path'], $view['namespace'] ?? $this->getNamespace());
        }

        // Load translations
        foreach ($this->registeredTranslations as $translation) {
            $this->loadTranslationsFrom($translation['path'], $translation['namespace'] ?? $this->getNamespace());
        }

        // Load config
        foreach ($this->registeredConfig as $config) {
            if (is_file($config['path'])) {
                $this->mergeConfigFrom($config['path'], $config['key'] ?? $this->getNamespace());
            }
        }

        // Load database seeders
        foreach ($this->registeredSeeders as $translation) {
            DatabaseSeeder::register($translation['class'], $translation['type']);
        }
    }

    protected function registerMigrations(string $path): void
    {
        $this->registeredMigrations[] = $path;
    }

    protected function registerViews(string $path, ?string $namespace = null): void
    {
        $this->registeredViews[] = compact('path', 'namespace');
    }

    protected function registerTranslations(string $path, ?string $namespace = null): void
    {
        $this->registeredTranslations[] = compact('path', 'namespace');
    }

    protected function registerConfig(string $path, ?string $key = null): void
    {
        $this->registeredConfig[] = compact('path', 'key');
    }

    protected function registerSeeder(string $class, SeederType $type): void
    {
        $this->registeredSeeders[] = compact('class', 'type');
    }
}
