<?php

namespace eResults\EmailTemplateBundle\Tests\Loader;

/**
 * TwigLoaderTest
 *
 */
class TwigLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadTemplate()
    {
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('renderBlock', 'loadTemplate'))
            ->getMock()
        ;

        $twigTemplate = $this->getMockBuilder('Twig_Template')
            ->disableOriginalConstructor()
            ->setMethods(array('renderBlock'))
            ->getMock()
        ;

        $twig->expects($this->once())
            ->method('loadTemplate')
            ->will($this->returnValue($twigTemplate))
        ;

        $htmlTemplate = array(
            'from' => 'example@example.com',
            'cc' => 'ccexample@example.com',
            'bcc' => 'bccexample@example.com',
            'subject' => 'Thanks for registering!',
            'body' => 'Body text'
        );

        $twigTemplate->expects($this->exactly(5))
            ->method('renderBlock')
            ->with($this->logicalOr('from', 'cc', 'bcc', 'subject', 'body'))
            ->will($this->returnCallback(function($block, $params) use ($htmlTemplate){
                return $htmlTemplate[$block];
            }))
        ;

        $loader = $this->getMockBuilder('eResults\EmailTemplateBundle\Loader\TwigLoader')
            ->setConstructorArgs(array($twig))
            ->setMethods(null)
            ->getMock()
        ;

        $template = $loader->load('email.html.twig');

        $this->assertInstanceOf('eResults\EmailTemplateBundle\Template\EmailTemplateInterface', $template);
        $this->assertEquals('example@example.com', $template->getFrom());
        $this->assertEquals('ccexample@example.com', $template->getCc());
        $this->assertEquals('bccexample@example.com', $template->getBcc());
        $this->assertEquals('Thanks for registering!', $template->getSubject());
        $this->assertEquals('Body text', $template->getBody());
    }
}
