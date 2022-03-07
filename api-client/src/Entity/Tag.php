<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\ManyToMany(targetEntity: PathItem::class, mappedBy: 'tags')]
    private Collection $pathItems;

    #[ORM\ManyToOne(targetEntity: OpenApiDocument::class, inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenApiDocument $openApiDocument;

    public function __construct()
    {
        $this->pathItems = new ArrayCollection();
    }

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|PathItem[]
     */
    public function getPathItems(): Collection
    {
        return $this->pathItems;
    }

    public function addPathItem(PathItem $pathItem): self
    {
        if (!$this->pathItems->contains($pathItem)) {
            $this->pathItems[] = $pathItem;
            $pathItem->addTag($this);
        }

        return $this;
    }

    public function removePathItem(PathItem $pathItem): self
    {
        if ($this->pathItems->removeElement($pathItem)) {
            $pathItem->removeTag($this);
        }

        return $this;
    }

    public function getOpenApiDocument(): ?OpenApiDocument
    {
        return $this->openApiDocument;
    }

    public function setOpenApiDocument(?OpenApiDocument $openApiDocument): self
    {
        $this->openApiDocument = $openApiDocument;

        return $this;
    }
}
