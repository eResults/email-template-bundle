<?php

namespace eResults\EmailTemplateBundle\Template;

class EmailTemplate implements EmailTemplateInterface
{
    protected string $from;
    protected ?string $cc;
    protected ?string $bcc;
    protected string $subject;
    protected string $body;

    public function __construct(string $from, string $subject, string $body, string $cc = null, string $bcc = null)
    {
        $this->from = $from;
        $this->subject = $subject;
        $this->body = $body;
        $this->cc = $cc;
        $this->bcc = $bcc;
    }

    /** @inheritDoc */
    public function getFrom(): string
    {
        return $this->from;
    }

    /** @inheritDoc */
    public function getCc(): ?string
    {
        return $this->cc;
    }

    /** @inheritDoc */
    public function getBcc(): ?string
    {
        return $this->bcc;
    }

    /** @inheritDoc */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /** @inheritDoc */
    public function getBody(): string
    {
        return $this->body;
    }
}
