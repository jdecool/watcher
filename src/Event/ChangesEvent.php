<?php

declare(strict_types=1);

namespace JDecool\Watcher\Event;

class ChangesEvent extends WatcherEvent
{
    private $added;
    private $removed;

    public function __construct(array $added, array $removed)
    {
        $this->added = $added;
        $this->removed = $removed;
    }
}
