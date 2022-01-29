<?php

namespace App\Entity;

use App\Repository\OAuthScopeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OAuthScopeRepository::class)]
class OAuthScope
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: OAuthFlow::class, inversedBy: 'scopes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OAuthFlow $flow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFlow(): ?OAuthFlow
    {
        return $this->flow;
    }

    public function setFlow(?OAuthFlow $flow): self
    {
        $this->flow = $flow;

        return $this;
    }
}
