<?php

declare(strict_types=1);

namespace JDecool\Watcher\Command;

use JDecool\Watcher\Event\ChangesEvent;
use JDecool\Watcher\Event\InitializedEvent;
use JDecool\Watcher\Event\NoChangesEvent;
use JDecool\Watcher\Storage\Storage;
use JDecool\Watcher\Watcher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WatchCommand extends Command
{
    private $watcher;
    private $storage;
    private $dispatcher;

    public function __construct(Watcher $watcher, Storage $storage, EventDispatcherInterface $dispatcher)
    {
        parent::__construct('watch');

        $this->watcher = $watcher;
        $this->storage = $storage;
        $this->dispatcher = $dispatcher;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objects = $this->watcher->getObjects();

        if (!$this->storage->isInitialized()) {
            $this->storage->persist($objects);

            $this->dispatcher->dispatch(InitializedEvent::class, new InitializedEvent($objects));

            return;
        }

        $ids = array_map(function($item) {
            return $item['id'];
        }, $objects);

        $cache = $this->storage->load();

        $idsAdded = array_diff($ids, $cache);
        $idsRemoved = array_diff($cache, $ids);

        if (!empty($idsAdded) || !empty($idsRemoved)) {
            $objectsAdded = array_filter($objects, function(array $item) use ($idsAdded): bool {
                return !in_array($item['id'], $idsAdded);
            });

            $objectsRemoved = array_map(function(array $item) use ($idsRemoved): bool {
                return !in_array($item['id'], $idsRemoved);
            }, $objects);

            $this->storage->persist($objects);

            $this->dispatcher->dispatch(ChangesEvent::class, new ChangesEvent($objectsAdded, $objectsRemoved));

            return;
        }

        $this->dispatcher->dispatch(NoChangesEvent::class);
    }
}
