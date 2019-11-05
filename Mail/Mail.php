<?php

namespace Disjfa\MailBundle\Mail;

use Disjfa\EnqueueBundle\Repository\MailTemplateRepository;
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
     * @var MailCollection
     */
    private $mailCollection;
    /**
     * @var MailTemplateRepository
     */
    private $mailTemplateRepository;

    /**
     * @param MailCollection         $mailCollection
     * @param MailTemplateRepository $mailTemplateRepository
     */
    public function __construct(MailCollection $mailCollection, MailTemplateRepository $mailTemplateRepository)
    {
        $this->mailCollection = $mailCollection;
        $this->mailTemplateRepository = $mailTemplateRepository;
    }

    /**
     * @param string $name
     *
     * @return Mail
     */
    public function findByName(string $name)
    {
        $this->mail = $this->mailCollection->findByName($name);
        $this->entity = $this->mailTemplateRepository->findOneByName($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->mail->getName();
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity->getSubject();
        }

        return $this->mail->getSubject();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity->getContent();
        }

        return $this->mail->getContent();
    }

    /**
     * @return string
     */
    public function getOriginalSubject()
    {
        return $this->mail->getSubject();
    }

    /**
     * @return string
     */
    public function getOriginalContent()
    {
        return $this->mail->getContent();
    }

    /**
     * @return MailTemplate
     *
     * @throws Exception
     */
    public function getEntity(): MailTemplate
    {
        if ($this->entity instanceof MailTemplate) {
            return $this->entity;
        }

        return new MailTemplate($this->mail->getName(), $this->mail->getSubject(), $this->mail->getContent());
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        preg_match_all("/{{\s*(\w+)\s*}}/", $this->getOriginalContent(), $body);
        preg_match_all("/{{\s*(\w+)\s*}}/", $this->getOriginalSubject(), $subject);

        return array_unique(array_merge($subject[1], $body[1]));
    }
}
