<?php

namespace Hito\Module;

interface  ModuleContract
{
    public function getId(): string;

    public function getName(): string;

    public function providers(): array;

    public function installed(): void;

    public function uninstalling(): void;

    public function enabling(): void;

    public function enabled(): void;

    public function disabling(): void;

    public function disabled(): void;

    public function isEnabled(): bool;

    public function publicPath(): ?string;

    public function assetUrl(): string;
}
