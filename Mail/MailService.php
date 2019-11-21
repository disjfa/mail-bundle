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
     * @var string
     */
    private $disjfaMailFrom;

    /**
     * MailService constructor.
     */
    public function __construct(Environment $twig, MailerInterface $mailer, EventDispatcherInterface $eventDispatcher, string $disjfaMailFrom)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->eventDispatcher = $eventDispatcher;
        $this->disjfaMailFrom = $disjfaMailFrom;
    }

    /**
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
        $email->from($this->disjfaMailFrom);
        $email->subject($subject);
        $email->html($this->twig->render('@DisjfaMail/mail/email.html.twig', [
            'content' => $content,
            'subject' => $subject,
        ]));

        return $email;
    }

    /**
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
