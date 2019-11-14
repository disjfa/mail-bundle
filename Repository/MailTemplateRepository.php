<?php

namespace Disjfa\MailBundle\Repository;

use Disjfa\MailBundle\Entity\MailTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MailTemplateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MailTemplate::class);
    }

    /**
     * @return MailTemplate|object|null
     */
    public function findOneByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }
}
