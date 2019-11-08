<?php

namespace Disjfa\MailBundle\Controller;

use Disjfa\MailBundle\Form\Type\MailTemplateType;
use Disjfa\MailBundle\Mail\Mail;
use Disjfa\MailBundle\Mail\MailCollection;
use Disjfa\MailBundle\Mail\MailFactory;
use Disjfa\MailBundle\Mail\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @Route("/mail-template")
 */
class MailTemplateController extends AbstractController
{
    /**
     * @Route("/", name="disjfa_mail_template_index")
     *
     * @return Response
     */
    public function index(MailCollection $mailCollection)
    {
        return $this->render('@DisjfaMail/mail-template/index.html.twig', [
            'mailCollection' => $mailCollection->getMails(),
        ]);
    }

    /**
     * @Route("/{name}/edit", name="disjfa_mail_template_edit")
     *
     * @return Response
     *
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function edit(string $name, MailFactory $mailFactory, Request $request, MailService $mailService)
    {
        $mail = $mailFactory->findByName($name);

        $form = $this->createForm(MailTemplateType::class, $mail->getEntity());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $mailService->create($mail, []);
            } catch (RuntimeError $error) {
                $form->addError(new FormError($error->getMessage()));
            }

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();

                $this->addFlash('success', 'Mail template saved');

                return $this->redirectToRoute('disjfa_mail_template_edit', [
                    'name' => $mail->getName(),
                ]);
            }
        }

        return $this->render('@DisjfaMail/mail-template/edit.html.twig', [
            'form' => $form->createView(),
            'mail' => $mail,
        ]);
    }

    /**
     * @Route("/{name}/preview", name="disjfa_mail_template_preview")
     *
     * @return Response
     *
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function preview(string $name, MailFactory $mailFactory, Request $request, MailService $mailService)
    {
        $mail = $mailFactory->findByName($name);

        $form = $this->createForm(MailTemplateType::class, $mail->getEntity());
        $form->handleRequest($request);

        $parameters = $mail->getParameters();
        $parameters = array_fill_keys($parameters, '');
        array_walk($parameters, function (&$item, $key) {
            $item = '## '.$key.' ##';
        });

        try {
            $email = $mailService->create($mail, $parameters);

            return new Response($email->getHtmlBody());
        } catch (RuntimeError $error) {
            return $this->render('@DisjfaMail/mail-template/error.html.twig', [
                'error' => $error,
            ]);
        }
    }
}
