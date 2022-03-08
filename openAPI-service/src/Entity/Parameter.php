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

    #[ORM\Column(type: 'string', length: 6)]
    private string $location;

    #[ORM\ManyToOne(targetEntity: Path::class, inversedBy: 'parameters')]
    private ?Path $path;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'json')]
    private array $parameterSchema = [];

    #[ORM\ManyToOne(targetEntity: PathItem::class, inversedBy: 'parameters')]
    #[ORM\JoinColumn(nullable: false)]
    private $pathItem;

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

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
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

    public function getPathItem(): ?PathItem
    {
        return $this->pathItem;
    }

    public function setPathItem(?PathItem $pathItem): self
    {
        $this->pathItem = $pathItem;

        return $this;
    }
}
