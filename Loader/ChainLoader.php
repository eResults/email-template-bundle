<?php

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;

class ChainLoader implements LoaderInterface
{
    protected array $loaders = [];

    public function addLoader(LoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }

    public function getLoaders(): array
    {
        return $this->loaders;
    }

    /** @inheritDoc */
    public function load($template, array $parameters = []): EmailTemplateInterface
    {
        if (0 == count($this->loaders)) {
            throw new \LogicException('You must add at least one loader.');
        }

        $emailTemplate = null;

        foreach ($this->loaders as $loader) {
            try {
                $emailTemplate = $loader->load($template, $parameters);

                break;
            } catch (LoaderException $e) {
                // skip to next
            }
        }

        if (null === $emailTemplate) {
            throw new LoaderException(sprintf('Could not load "%s" template.', $template));
        }

        return $emailTemplate;
    }
}
