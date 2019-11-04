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
     * @param string $name
     * @param string $subject
     * @param string $content
     *
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
