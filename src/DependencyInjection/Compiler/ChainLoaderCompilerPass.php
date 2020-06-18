<?php

namespace eResults\EmailTemplateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ChainLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('eresults_email_template.loader.chain')) {
            return;
        }

        $definition = $container->getDefinition('eresults_email_template.loader.chain');

        foreach ($container->findTaggedServiceIds('eresults_email_template.chain_loader') as $id => $attributes) {
            $definition->addMethodCall('addLoader', array(new Reference($id)));
        }
    }
}
