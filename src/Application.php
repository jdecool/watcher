<?php

declare(strict_types=1);

namespace JDecool\Watcher;

use JDecool\Watcher\Command\WatchCommand;
use RuntimeException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    public function __construct(string $name, string $version)
    {
        parent::__construct($name, $version);

        $processor = new Processor();
        $configuration = $processor->processConfiguration(
            new Configuration(),
            [Yaml::parse(file_get_contents($this->getConfigurationPath()))]
        );

        $dispatcher = new EventDispatcher();
        foreach ($configuration['listeners'] as $listener) {
            $dispatcher->addSubscriber(new $listener);
        }

        $command = new WatchCommand(new $configuration['watcher'], new $configuration['storage'], $dispatcher);
        $this->add($command);

        $this->setDefaultCommand($command->getName());
    }

    private function getConfigurationPath(): string
    {
        $files = [
            getcwd().'/watcher.yaml',
            getcwd().'/watcher.yml',
            __DIR__.'/../../../../watcher.yaml',
            __DIR__.'/../../../../watcher.yml',
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                return $file;
            }
        }

        throw new RuntimeException('No configuration file found');
    }
}
