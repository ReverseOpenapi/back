<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean')]
    private ?bool $required;

    #[ORM\ManyToOne(targetEntity: ParameterLocation::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ParameterLocation $location;

    #[ORM\ManyToOne(targetEntity: Path::class, inversedBy: 'parameters')]
    private ?Path $path;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'json')]
    private array $parameterSchema = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getLocation(): ?ParameterLocation
    {
        return $this->location;
    }

    public function setLocation(?ParameterLocation $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

        return $this;
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

    public function getParameterSchema(): ?array
    {
        return $this->parameterSchema;
    }

    public function setParameterSchema(array $parameterSchema): self
    {
        $this->parameterSchema = $parameterSchema;

        return $this;
    }
}