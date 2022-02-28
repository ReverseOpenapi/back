<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schema
 *
 * @ORM\Table(name="schema")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SchemaRepository")
 */
class Schema
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="content", type="json", nullable=false)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }


}
