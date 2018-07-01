<?php

declare(strict_types=1);

namespace JDecool\Watcher;

use JDecool\Watcher\Storage\JsonStorage;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('watcher');
        $rootNode
            ->children()
                ->scalarNode('watcher')->isRequired()->end()
                ->scalarNode('storage')->defaultValue(JsonStorage::class)->end()
                ->arrayNode('listeners')
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
