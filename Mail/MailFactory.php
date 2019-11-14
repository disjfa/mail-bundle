<?php

namespace Disjfa\MailBundle\Mail;

use Disjfa\MailBundle\Repository\MailTemplateRepository;

class MailFactory
{
    /**
     * @var MailCollection
     */
    private $mailCollection;
    /**
     * @var MailTemplateRepository
     */
    private $mailTemplateRepository;

    public function __construct(MailCollection $mailCollection, MailTemplateRepository $mailTemplateRepository)
    {
        $this->mailCollection = $mailCollection;
        $this->mailTemplateRepository = $mailTemplateRepository;
    }

    public function findByName(string $name): Mail
    {
        $mail = $this->mailCollection->findByName($name);
        $entity = $this->mailTemplateRepository->findOneByName($name);

        return new Mail($mail, $entity);
    }
}
