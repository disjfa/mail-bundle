<?php

namespace Disjfa\MailBundle\Example;

use Disjfa\MailBundle\Mail\MailInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ExampleMail implements MailInterface
{
    const NAME = 'disjfa_mail.example';
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(Environment $environment, TranslatorInterface $translator)
    {
        $this->environment = $environment;
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->translator->trans('example.subject', [], 'disjfa-mail');
    }

    /**
     * @return string
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getContent()
    {
        return $this->environment->render('@DisjfaMail/example/index.html.twig');
    }
}
