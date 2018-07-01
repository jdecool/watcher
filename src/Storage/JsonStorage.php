<?php

declare(strict_types=1);

namespace JDecool\Watcher\Storage;

class JsonStorage extends Storage
{
    private $configurationFile;

    public function __construct(string $configurationFile = 'var/watcher.data')
    {
        $directory = dirname($configurationFile);
        if (!file_exists($directory)) {
            mkdir($directory);
        }

        $this->configurationFile = $configurationFile;
    }

    public function isInitialized(): bool
    {
        return file_exists($this->configurationFile);
    }

    public function persist(array $objects): void
    {
        $objectsIds = array_map(function(array $item) {
            return $item['id'];
        }, $objects);

        file_put_contents($this->configurationFile, json_encode($objectsIds, JSON_PRETTY_PRINT));
    }

    public function load(): array
    {
        $json = file_get_contents($this->configurationFile);

        return json_decode($json, true);
    }
}
