<?php

namespace Disjfa\MailBundle;

use Disjfa\MailBundle\DependencyInjection\DisjfaMailPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DisjfaMailBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DisjfaMailPass());
    }
}
