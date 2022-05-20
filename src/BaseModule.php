<?php

namespace Hito\Module;

use Hito\Core\Module\Services\ModuleService;

abstract class BaseModule implements ModuleContract
{
    abstract public function publicPath(): ?string;

    public static function new(): static {
        return new static();
    }

    public function installed(): void
    {
    }

    public function uninstalling(): void
    {
    }

    public function enabling(): void
    {
    }

    public function enabled(): void
    {
    }

    public function disabling(): void
    {
    }

    public function disabled(): void
    {
    }

    public function isEnabled(): bool
    {
        return app(ModuleService::class)->isActive($this->getId());
    }

    public function assetUrl(): string
    {
        return asset(config('app.asset_directory_modules') . "/{$this->getId()}/");
    }
}
