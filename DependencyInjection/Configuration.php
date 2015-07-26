<?php

namespace Strontium\SpecificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('specification');

        $rootNode
            ->children()
                ->arrayNode('specifications')
                    ->useAttributeAsKey('name')
                    ->prototype('variable')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
