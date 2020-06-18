<?php

namespace eResults\EmailTemplateBundle\Loader;

use eResults\EmailTemplateBundle\Template\EmailTemplate;
use eResults\EmailTemplateBundle\Template\EmailTemplateInterface;

interface LoaderInterface
{
    /**
     * Load email template
     *
     * @param mixed $template Template to load
     * @param array $parameters Template parameters
     *
     * @return EmailTemplate
     */
    function load($template, array $parameters = []): EmailTemplateInterface;
}
