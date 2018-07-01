<?php

declare(strict_types=1);

namespace JDecool\Watcher;

class ApplicationFactory
{
    public const NAME = 'watcher';
    public const VERSION = 'alpha';

    public function createApplication(): Application
    {
        return new Application(self::NAME, self::VERSION);
    }
}
