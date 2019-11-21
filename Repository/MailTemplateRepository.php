<?php

namespace Disjfa\MailBundle\Repository;

use Disjfa\MailBundle\Entity\MailTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MailTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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
