<?php

namespace Disjfa\MailBundle\Example;

use Disjfa\MailBundle\Mail\MailInterface;
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
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
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
        return 'Example {{subject}}';
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
