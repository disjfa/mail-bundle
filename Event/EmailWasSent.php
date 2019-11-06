<?php

namespace Disjfa\MailBundle\Event;

use Symfony\Component\Mime\Email;

class EmailWasSent
{
    const NAME = 'disjfa_mail.email_was_sent';
    /**
     * @var Email
     */
    private $email;

    /**
     * EmailWasSent constructor.
     *
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
