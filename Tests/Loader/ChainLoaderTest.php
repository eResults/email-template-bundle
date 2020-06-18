<?php

namespace eResults\EmailTemplateBundle\Tests\Loader;

use eResults\EmailTemplateBundle\Loader\LoaderInterface;
use eResults\EmailTemplateBundle\Template\EmailTemplate;

class ChainLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddLoader()
    {
        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\ChainLoader')
            ->setMethods(array('addLoader'))
            ->getMock()
        ;

        $this->assertTrue(is_array($loader->getLoaders()));
        $this->assertEquals(0, count($loader->getLoaders()));

        $loader->expects($this->once())
            ->method('addLoader')
        ;

        $loader->addLoader(new TestLoader());

        try {
            $loader->addLoader(new \stdClass());
        } catch(\Exception $e) {
            // pass
            return;
        }

        $this->fail('An expected exception has not been raised, addLoader must accept LoaderInterface.');
    }

    public function testNoLoaders()
    {
        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\ChainLoader')
            ->setMethods(null)
            ->getMock()
        ;

        $this->setExpectedException('LogicException');

        // should throw exception because no loaders added before ->load()
        $loader->load('email.html.twig');
    }

    public function testOneLoader()
    {
        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\ChainLoader')
            ->setMethods(null)
            ->getMock()
        ;

        $loader->addLoader(new TestLoader());

        $template = $loader->load('email.html.twig');

        $this->assertInstanceOf('eResults\EmailTemplateBundle\Template\EmailTemplateInterface', $template);
        $this->assertEquals('example@example.com', $template->getFrom());
        $this->assertEquals('ccexample@example.com', $template->getCc());
        $this->assertEquals('bccexample@example.com', $template->getBcc());
        $this->assertEquals('Test subject', $template->getSubject());
        $this->assertEquals('Test body', $template->getBody());

    }
}

class TestLoader implements LoaderInterface
{

    public function load($template, array $parameters = array())
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
