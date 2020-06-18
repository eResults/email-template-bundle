<?php

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplate;
use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;
use Twig\Environment;

final class ObjectLoader implements LoaderInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = clone $twig;
    }

    /** @inheritDoc */
    public function load($template, array $parameters = []): EmailTemplate
    {
        if (!$template instanceof EmailTemplateInterface) {
            throw new \InvalidArgumentException(sprintf('Instance of "EmailTemplateInterface" expected, "%s" given.', gettype($template)));
        }

        $from = $this->twig->render(
            $this->twig->createTemplate($template->getFrom()),
            $parameters
        );

        $cc = $this->twig->render(
            $this->twig->createTemplate($template->getCc()),
            $parameters
        );

        $bcc = $this->twig->render(
            $this->twig->createTemplate($template->getBcc()),
            $parameters
        );

        $subject = $this->twig->render(
            $this->twig->createTemplate($template->getSubject()),
            $parameters
        );

        $body = $this->twig->render(
            $this->twig->createTemplate($template->getBody()),
            $parameters
        );

        return new EmailTemplate(
            $from,
            $subject,
            $body,
            $cc,
            $bcc
        );
    }
}
