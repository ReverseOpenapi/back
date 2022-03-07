<?php

namespace App\Entity;

use App\Repository\SchemaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchemaRepository::class)]
class Schema
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    /**
     * @var array<mixed>
     */
    #[ORM\Column(type: 'json')]
    private array $content = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array<mixed>|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param array<mixed> $content
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }
}
