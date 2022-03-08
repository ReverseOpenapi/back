<?php

namespace App\Entity;

use App\Repository\OpenApiDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity(repositoryClass: OpenApiDocumentRepository::class)]
class OpenApiDocument
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class:UuidGenerator::class)]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Path::class, orphanRemoval: true)]
    private Collection $paths;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Tag::class, orphanRemoval: true)]
    private Collection $tags;

    #[ORM\Column(type: 'string', length: 255)]
    private $version;

    public function __construct()
    {
        $this->paths = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection|Path[]
     */
    public function getPaths(): Collection
    {
        return $this->paths;
    }

    public function addPath(Path $path): self
    {
        if (!$this->paths->contains($path)) {
            $this->paths[] = $path;
            $path->setOpenApiDocument($this);
        }

        return $this;
    }

    public function removePath(Path $path): self
    {
        if ($this->paths->removeElement($path)) {
            // set the owning side to null (unless already changed)
            if ($path->getOpenApiDocument() === $this) {
                $path->setOpenApiDocument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setOpenApiDocument($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getOpenApiDocument() === $this) {
                $tag->setOpenApiDocument(null);
            }
        }

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
