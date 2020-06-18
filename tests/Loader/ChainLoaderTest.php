<?php

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplate;
use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;
use PHPUnit\Framework\TestCase;

class ChainLoaderTest extends TestCase
{
    public function testAddLoader()
    {
        $loader = new ChainLoader();

        $this->assertTrue(is_array($loader->getLoaders()));
        $this->assertCount(0, $loader->getLoaders());

        $loader->addLoader(new ChainLoaderTestTestLoader());
        $this->assertCount(1, $loader->getLoaders());
    }

    public function testNoLoaders()
    {
        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\ChainLoader')
            ->setMethods(null)
            ->getMock()
        ;

        $this->expectException('LogicException');

        // should throw exception because no loaders added before ->load()
        $loader->load('email.html.twig');
    }

    public function testOneLoader()
    {
        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\ChainLoader')
            ->setMethods(null)
            ->getMock()
        ;

        $loader->addLoader(new ChainLoaderTestTestLoader());

        $template = $loader->load('email.html.twig');

        $this->assertInstanceOf('eResults\EmailTemplateBundle\Template\EmailTemplateInterface', $template);
        $this->assertEquals('example@example.com', $template->getFrom());
        $this->assertEquals('ccexample@example.com', $template->getCc());
        $this->assertEquals('bccexample@example.com', $template->getBcc());
        $this->assertEquals('Test subject', $template->getSubject());
        $this->assertEquals('Test body', $template->getBody());

    }
}

class ChainLoaderTestTestLoader implements LoaderInterface
{
    public function load($template, array $parameters = []): EmailTemplateInterface
    {
        return new EmailTemplate(
            'example@example.com',
            'Test subject',
            'Test body',
            'ccexample@example.com',
            'bccexample@example.com'
        );
    }
}
