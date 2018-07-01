<?php

declare(strict_types=1);

namespace JDecool\Watcher\Event;

class InitializedEvent extends WatcherEvent
{
    private $objects;

    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    public function getObjects(): array
    {
        return $this->objects;
    }
}
