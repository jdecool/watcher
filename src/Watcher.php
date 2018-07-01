<?php

declare(strict_types=1);

namespace JDecool\Watcher;

abstract class Watcher
{
    public abstract function getObjects(): array;
}
