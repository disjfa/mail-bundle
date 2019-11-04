<?php

namespace Disjfa\MailBundle\DependencyInjection;

use Disjfa\MailBundle\Mail\MailInterface;
use Exception;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class DisjfaMailPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getServiceIds() as $serviceId) {
            $this->tagMailerInterfaces($serviceId, $container);
        }
    }

    /**
     * @param string           $serviceId
     * @param ContainerBuilder $container
     */
    public function tagMailerInterfaces($serviceId, ContainerBuilder $container)
    {
        try {
            $definition = $container->getDefinition($serviceId);
        } catch (ServiceNotFoundException $e) {
            return;
        }

        if ( ! $definition->getClass()) {
            return;
        }

        try {
            $reflection = new ReflectionClass($definition->getClass());
        } catch (ReflectionException $e) {
            return;
        }

        foreach ($reflection->getInterfaces() as $interface) {
            if (MailInterface::class === $interface->getName()) {
                if (false === $definition->hasTag('disjfa.mail')) {
                    $definition->addTag('disjfa.mail');
                }
            }
        }
    }
}
