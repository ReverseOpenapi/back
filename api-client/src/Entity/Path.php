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
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: OpenApiDocument::class, inversedBy: 'paths')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenApiDocument $openApiDocument;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $endpoint;

    #[ORM\OneToMany(mappedBy: 'path', targetEntity: PathItem::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $pathItems;

    #[ORM\OneToMany(mappedBy: 'path', targetEntity: Parameter::class, cascade: ["persist"])]
    private Collection $parameters;

    public function __construct(array $data = [])
    {

        if (count($data)) {
            $this->endpoint = $data['endpoint'] ?? null;
        }

        $this->pathItems = new ArrayCollection();
        $this->parameters = new ArrayCollection();
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

    public function removePathItem(PathItem $pathItem): self
    {
        if ($this->pathItems->removeElement($pathItem)) {
            // set the owning side to null (unless already changed)
            if ($pathItem->getPath() === $this) {
                $pathItem->setPath(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Parameter[]
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function addParameter(Parameter $parameter): self
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters[] = $parameter;
            $parameter->setPath($this);
        }

        return $this;
    }

    public function removeParameter(Parameter $parameter): self
    {
        if ($this->parameters->removeElement($parameter)) {
            // set the owning side to null (unless already changed)
            if ($parameter->getPath() === $this) {
                $parameter->setPath(null);
            }
        }

        return $this;
    }

    public function toArray() {
        // dd($this->pathItems->toArray());
        return [
            'endpoint'          => $this->endpoint,
            'pathItems'         => array_map(function ($pathItem) {
                return $pathItem->toArray();
            }, $this->pathItems->toArray()),
            'parameters'    => array_map(function ($parameter) {
                return $parameter->toArray();
            }, $this->parameters->toArray()),
        ];
    }
}
