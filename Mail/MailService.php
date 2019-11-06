<?php

namespace Disjfa\MailBundle\Mail;

use Disjfa\MailBundle\Event\EmailWasSent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\NamedAddress;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailService
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * MailService constructor.
     *
     * @param Environment              $twig
     * @param MailerInterface          $mailer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Environment $twig, MailerInterface $mailer, EventDispatcherInterface $eventDispatcher)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Mail  $mail
     * @param array $parameters
     *
     * @return Email
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function create(Mail $mail, array $parameters = [])
    {
        $parameters = array_merge(array_fill_keys($mail->getParameters(), ''), $parameters);

        $subjectTemplate = $this->twig->createTemplate($mail->getSubject());
        $contentTemplate = $this->twig->createTemplate($mail->getContent());

        $content = $this->twig->render($contentTemplate, $parameters);
        $subject = $this->twig->render($subjectTemplate, $parameters);

        $email = new Email();
        $email->from('disjfa@disjfa.nl');
        $email->subject($subject);
        $email->html($this->twig->render('@DisjfaMail/mail/email.html.twig', [
            'content' => $content,
        ]));

        return $email;
    }

    /**
     * @param Mail                        $mail
     * @param array                       $parameters
     * @param Address|NamedAddress|string ...$addresses
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function send(Mail $mail, array $parameters = [], ...$addresses)
    {
        $email = $this->create($mail, $parameters);
        $email->to(...$addresses);

        $this->mailer->send($email);

        $this->eventDispatcher->dispatch(new EmailWasSent($email));
    }
}
