<?php

namespace Disjfa\MailBundle\Controller\Admin;

use Disjfa\MailBundle\Mail\Mail;
use Disjfa\MailBundle\Mail\MailCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mail")
 */
class MailController extends AbstractController
{
    /**
     * @Route("/", name="disjfa_mail_admin_mail_index")
     *
     * @param MailCollection $mailCollection
     *
     * @return Response
     */
    public function index(MailCollection $mailCollection)
    {
        return $this->render('@DisjfaMail/admin/mail/index.html.twig', [
            'mailCollection' => $mailCollection->getMails(),
        ]);
    }

    /**
     * @Route("/{name}/edit", name="disjfa_mail_admin_mail_edit")
     *
     * @param string $name
     * @param Mail $mail
     *
     * @return Response
     * @throws Exception
     */
    public function edit(string $name, Mail $mail)
    {
        $mail = $mail->findByName($name);
        return $this->render('@DisjfaMail/admin/mail/edit.html.twig', [
            'mail' => $mail,
        ]);
    }
}
