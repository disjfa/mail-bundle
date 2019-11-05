<?php

namespace Disjfa\MailBundle\Controller\Admin;

use Disjfa\MailBundle\Form\Type\MailTemplateType;
use Disjfa\MailBundle\Mail\Mail;
use Disjfa\MailBundle\Mail\MailCollection;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param string  $name
     * @param Mail    $mail
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function edit(string $name, Mail $mail, Request $request)
    {
        $mail = $mail->findByName($name);
        dump($mail->getParameters());

        $form = $this->createForm(MailTemplateType::class, $mail->getEntity());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Mail template saved');

            return $this->redirectToRoute('disjfa_mail_admin_mail_edit', [
                'name' => $mail->getName(),
            ]);
        }

        return $this->render('@DisjfaMail/admin/mail/edit.html.twig', [
            'form' => $form->createView(),
            'mail' => $mail,
        ]);
    }

    /**
     * @Route("/{name}/preview", name="disjfa_mail_admin_mail_preview")
     *
     * @param string $name
     * @param Mail   $mail
     *
     * @return Response
     *
     * @throws Exception
     */
    public function preview(string $name, Mail $mail)
    {
        $mail = $mail->findByName($name);

        return $this->render('@DisjfaMail/mail/email.html.twig', [
            'content' => $mail->getContent(),
        ]);
    }
}
