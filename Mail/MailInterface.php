<?php

namespace Disjfa\MailBundle\Mail;

interface MailInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getContent();
}
