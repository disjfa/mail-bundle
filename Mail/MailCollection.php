<?php

namespace Disjfa\MailBundle\Mail;

class MailCollection
{
    /**
     * @var MailInterface[]|iterable
     */
    private $mails;

    /**
     * @param MailInterface[] $mails
     */
    public function __construct(iterable $mails)
    {
        $this->mails = $mails;
    }

    /**
     * @return MailInterface[]|iterable
     */
    public function getMails()
    {
        return $this->mails;
    }
}
