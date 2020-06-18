<?php

namespace eResults\EmailTemplateBundle\Tests\DependencyInjection;

use eResults\EmailTemplateBundle\DependencyInjection\eResultsEmailTemplateExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

class eResultsEmailTemplateExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new eResultsEmailTemplateExtension();
        $loader->load(array(array()), $container);
        $this->assertTrue($container->hasDefinition('eresults_email_template.loader.twig'), 'Has twig service/loader');
        $this->assertTrue($container->hasAlias('eresults_email_template.loader'), 'Has default loader alias');
    }

    public function testOverwriteDefaultLoader()
    {
        $container = new ContainerBuilder();
        $loader = new eResultsEmailTemplateExtension();
        $loader->load(array(array('default_loader' =>'foobar')), $container);
        $this->assertEquals('foobar', $container->getAlias('eresults_email_template.loader'));
    }
}
