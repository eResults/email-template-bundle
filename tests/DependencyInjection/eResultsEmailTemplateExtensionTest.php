<?php

namespace eResults\EmailTemplateBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class eResultsEmailTemplateExtensionTest extends TestCase
{
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new eResultsEmailTemplateExtension();
        $loader->load([[]], $container);
        $this->assertTrue($container->hasDefinition('eresults_email_template.loader.twig'), 'Has twig service/loader');
        $this->assertTrue($container->hasAlias('eresults_email_template.loader'), 'Has default loader alias');
    }

    public function testOverwriteDefaultLoader()
    {
        $container = new ContainerBuilder();
        $loader = new eResultsEmailTemplateExtension();
        $loader->load([['default_loader' => 'foobar']], $container);
        $this->assertEquals('foobar', $container->getAlias('eresults_email_template.loader'));
    }
}
