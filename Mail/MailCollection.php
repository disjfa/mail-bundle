<?php

namespace Disjfa\MailBundle\Mail;

use InvalidArgumentException;

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

    /**
     * @return MailInterface
     */
    public function findByName(string $name)
    {
        foreach ($this->mails as $mail) {
            if ($mail->getName() === $name) {
                return $mail;
            }
        }

        throw new InvalidArgumentException('No email found');
    }
}
