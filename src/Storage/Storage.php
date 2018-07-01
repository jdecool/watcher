<?php

declare(strict_types=1);

namespace JDecool\Watcher\Storage;

abstract class Storage
{
    public abstract function isInitialized(): bool;
    public abstract function load(): array;
    public abstract function persist(array $objects): void;
}
