<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag", indexes={@ORM\Index(name="IDX_389B7832D58E2A8", columns={"open_api_document_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var \OpenApiDocument
     *
     * @ORM\ManyToOne(targetEntity="OpenApiDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="open_api_document_id", referencedColumnName="id")
     * })
     */
    private $openApiDocument;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PathItem", mappedBy="tag")
     */
    private $pathItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pathItem = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Collection<int, PathItem>
     */
    public function getPathItem(): Collection
    {
        return $this->pathItem;
    }

    public function addPathItem(PathItem $pathItem): self
    {
        if (!$this->pathItem->contains($pathItem)) {
            $this->pathItem[] = $pathItem;
            $pathItem->addTag($this);
        }

        return $this;
    }

    public function removePathItem(PathItem $pathItem): self
    {
        if ($this->pathItem->removeElement($pathItem)) {
            $pathItem->removeTag($this);
        }

        return $this;
    }

}
