<?php

declare(strict_types=1);

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplate;
use Twig\Environment;
use Twig\Error\LoaderError;

class TwigLoader implements LoaderInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function load($template, array $parameters = []): EmailTemplate
    {
        if (!is_string($template)) {
            throw new \InvalidArgumentException(sprintf('string expected, "%s" given.', gettype($template)));
        }

        try {
            $twigTemplate = $this->twig->load($template);
        } catch (LoaderError $e) {
            throw new LoaderException(sprintf('Could not load "%s" template.', $template), $e->getCode(), $e);
        }

        return new EmailTemplate(
            $twigTemplate->renderBlock('from', $parameters),
            $twigTemplate->renderBlock('subject', $parameters),
            $twigTemplate->renderBlock('body', $parameters),
            $twigTemplate->renderBlock('cc', $parameters),
            $twigTemplate->renderBlock('bcc', $parameters)
        );
    }
}
