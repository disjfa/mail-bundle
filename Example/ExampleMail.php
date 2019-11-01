<?php

namespace Disjfa\MailBundle\Example;

use Disjfa\MailBundle\Mail\MailInterface;
use Twig\Environment;

class ExampleMail implements MailInterface
{
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }
    /**
     * @return string
     */
    public function getSubject()
    {
        return 'hello';
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->getOriginalContent();
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getOriginalContent()
    {
        return $this->environment->render('@DisjfaMail/example/index.html.twig');
    }
}
