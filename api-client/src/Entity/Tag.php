<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: PathItem::class, mappedBy: 'tags')]
    private Collection $pathItems;

    #[ORM\ManyToOne(targetEntity: OpenApiDocument::class, inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenApiDocument $openApiDocument;

    public function __construct(array $data = [])
    {
        if (count($data)) {
            $this->name         = $data['name'] ?? null;
            $this->description  = $data['description'] ?? null;
        }

        $this->pathItems = new ArrayCollection();
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

    public function toArray() {
        return [
            'name'          => $this->name,
            'description'   => $this->description
        ];
    }
}
