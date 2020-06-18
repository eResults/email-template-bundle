<?php

namespace eResults\EmailTemplateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @inheritdoc */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('eresults_email_template');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('default_loader')->defaultValue('eresults_email_template.loader.twig')
            ->end()
        ;

        return $treeBuilder;
    }
}
