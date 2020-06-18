<?php

namespace eResults\EmailTemplateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use eResults\EmailTemplateBundle\DependencyInjection\Compiler\ChainLoaderCompilerPass;

class eResultsEmailTemplateBundle extends Bundle
{
    /** @inheritdoc */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ChainLoaderCompilerPass());
    }

    public function getContainerExtension()
    {
        return $this->extension ?: ($this->extension = $this->createContainerExtension());
    }
}
