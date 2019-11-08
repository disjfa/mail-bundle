<?php

namespace Disjfa\MailBundle\Mail;

use Disjfa\MailBundle\Entity\MailTemplate;
use Exception;

class Mail
{
    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var MailTemplate|null
     */
    private $entity;

    /**
     * @param MailTemplate $mailTemplate
     */
    public function __construct(MailInterface $mail, MailTemplate $mailTemplate = null)
    {
        $this->mail = $mail;
        $this->entity = $mailTemplate;
    }

    public function getName(): string
    {
        return $this->mail->getName();
    }

    public function getSubject(): string
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity->getSubject();
        }

        return $this->mail->getSubject();
    }

    public function getContent(): string
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity->getContent();
        }

        return $this->mail->getContent();
    }

    public function getOriginalSubject(): string
    {
        return $this->mail->getSubject();
    }

    public function getOriginalContent(): string
    {
        return $this->mail->getContent();
    }

    /**
     * @throws Exception
     */
    public function getEntity(): MailTemplate
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity;
        }

        return new MailTemplate($this->mail->getName(), $this->mail->getSubject(), $this->mail->getContent());
    }

    public function getParameters(): array
    {
        preg_match_all("/{{\s*(\w+)\s*}}/", $this->getOriginalContent(), $body);
        preg_match_all("/{{\s*(\w+)\s*}}/", $this->getOriginalSubject(), $subject);

        return array_unique(array_merge($subject[1], $body[1]));
    }
}
