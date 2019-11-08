<?php

namespace Disjfa\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class MailTemplate
{
    /**
     * @var Uuid
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=36)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string")
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @throws Exception
     */
    public function __construct(string $name, string $subject, string $content)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * @return Uuid
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
