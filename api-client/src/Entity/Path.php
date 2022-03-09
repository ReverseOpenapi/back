<?php

namespace App\Entity;

use App\Repository\PathRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PathRepository::class)]
class Path
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $endpoint;

    #[ORM\OneToMany(mappedBy: 'path', targetEntity: PathItem::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $pathItems;

    #[ORM\ManyToOne(targetEntity: OpenApiDocument::class, inversedBy: 'paths')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenApiDocument $openApiDocument;

    public function __construct(array $data = [])
    {

        if (count($data)) {
            $this->endpoint = $data['endpoint'] ?? null;
        }

        $this->pathItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|PathItem[]
     */
    public function getpathItems(): Collection
    {
        return $this->pathItems;
    }

    public function addPathItem(PathItem $pathItem): self
    {
        if (!$this->pathItems->contains($pathItem)) {
            $this->pathItems[] = $pathItem;
            $pathItem->setPath($this);
        }

        return $this;
    }

    public function toArray() {

        return [
            'endpoint'          => $this->endpoint,
            'pathItems'         => array_map(function ($pathItem) {
                return $pathItem->toArray();
            }, $this->pathItems->toArray()),
        ];
    }
}
