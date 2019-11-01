<?php

namespace Disjfa\MailBundle\Controller\Admin;

use Disjfa\MailBundle\Mail\MailCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mail")
 */
class MailController extends AbstractController
{
    /**
     * @Route("/", name="disjfa_mail_admin_mail_index")
     * @param MailCollection $mailCollection
     */
    public function index(MailCollection $mailCollection)
    {
        foreach($mailCollection->getMails() as $mail) {
            dump($mail->getContent());
        }
        exit;
    }
}
