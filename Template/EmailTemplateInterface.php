<?php

namespace eResults\EmailTemplateBundle\Template;

/**
 * EmailTemplateInterface
 *
 */
interface EmailTemplateInterface
{
    /**
     * From email address
     *
     * @return string
     */
    function getFrom(): string;

    /**
     * CC address
     *
     * @return string
     */
    function getCc(): ?string;

    /**
     * Bcc address
     *
     * @return string
     */
    function getBcc(): ?string;

    /**
     * Email subject
     *
     * @return string
     */
    function getSubject(): string;

    /**
     * Email body
     *
     * @return string
     */
    function getBody(): string;
}
