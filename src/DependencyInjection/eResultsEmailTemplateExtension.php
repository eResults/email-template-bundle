<?php

namespace eResults\EmailTemplateBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class eResultsEmailTemplateExtension extends Extension
{
    public function getAlias()
    {
        return 'eresults_email_template';
    }

    /**
     * {@inheritdoc}
     *
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $container->setAlias('eresults_email_template.loader', $config['default_loader']);
    }
}
