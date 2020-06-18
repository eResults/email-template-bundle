<?php

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\TemplateWrapper;

class TwigLoaderTest extends TestCase
{
    public function testLoadTemplate()
    {
        /** @var Environment|MockObject $twig */
        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['load'])
            ->getMock()
        ;

        /** @var TemplateWrapper|MockObject $twigTemplate */
        $twigTemplate = $this->getMockBuilder(TemplateWrapper::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $htmlTemplate = [
            'from' => 'example@example.com',
            'cc' => 'ccexample@example.com',
            'bcc' => 'bccexample@example.com',
            'subject' => 'Thanks for registering!',
            'body' => 'Body text',
        ];

        $twigTemplate->expects($this->exactly(5))
            ->method('renderBlock')
            ->with($this->logicalOr('from', 'cc', 'bcc', 'subject', 'body'))
            ->will($this->returnCallback(function ($block, $params) use ($htmlTemplate) {
                return $htmlTemplate[$block];
            }))
        ;

        $twig->expects($this->once())
            ->method('load')
            ->will($this->returnValue($twigTemplate))
        ;

        $loader = new TwigLoader($twig);

        $template = $loader->load('email.html.twig');

        $this->assertInstanceOf(EmailTemplateInterface::class, $template);
        $this->assertEquals('example@example.com', $template->getFrom());
        $this->assertEquals('ccexample@example.com', $template->getCc());
        $this->assertEquals('bccexample@example.com', $template->getBcc());
        $this->assertEquals('Thanks for registering!', $template->getSubject());
        $this->assertEquals('Body text', $template->getBody());
    }
}
